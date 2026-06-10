<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\Criteria;
use App\Models\MooraSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_internships' => Internship::whereNull('user_id')->count(),
            'total_user_internships' => Internship::whereNotNull('user_id')->count(),
            'total_sessions' => MooraSession::count(),
            'avg_alternatives' => round(DB::table('internship_evaluations')
                ->select('moora_session_id', DB::raw('count(distinct internship_id) as count'))
                ->groupBy('moora_session_id')
                ->get()
                ->avg('count') ?? 0, 1),
        ];

        // Chart 1: Registration Growth (6 Months)
        $registrationTrends = collect();
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $count = User::where('role', 'user')
                ->whereMonth('created_at', $monthDate->month)
                ->whereYear('created_at', $monthDate->year)
                ->count();
            $registrationTrends->push((object)['label' => $monthDate->format('M Y'), 'count' => $count]);
        }

        // Chart 2: MOORA Activity (7 Days)
        $sessionTrend = MooraSession::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')->orderBy('date')->get()
            ->map(fn($i) => (object)['date' => \Carbon\Carbon::parse($i->date)->format('d M'), 'count' => $i->count]);

        // Chart 3: Top 5 Most Compared Companies
        $topCompared = DB::table('internship_evaluations')
            ->join('internships', 'internship_evaluations.internship_id', '=', 'internships.id')
            ->select('internships.name', DB::raw('count(distinct moora_session_id) as total'))
            ->groupBy('internships.id', 'internships.name')
            ->orderBy('total', 'desc')->limit(5)->get();

        // Chart 4: Top User Contributed Companies
        $topUserContributions = Internship::whereNotNull('user_id')
            ->select(DB::raw('LOWER(name) as lower_name'), DB::raw('MAX(name) as name'), DB::raw('count(*) as count'))
            ->groupBy('lower_name')
            ->orderBy('count', 'desc')
            ->limit(5)->get();

        // Chart 5: Criteria Importance (Avg Weights across all users)
        $criteriaWeights = DB::table('user_criteria_weights')
            ->join('criterias', 'user_criteria_weights.criteria_id', '=', 'criterias.id')
            ->select('criterias.name', DB::raw('AVG(weight) as avg_weight'))
            ->groupBy('criterias.id', 'criterias.name')
            ->orderBy('avg_weight', 'desc')->get();

        // Data 5: Winners Leaderboard (Win Rate)
        $topWinners = MooraSession::select('winner_name', DB::raw('count(*) as win_count'))
            ->groupBy('winner_name')
            ->orderBy('win_count', 'desc')->limit(5)->get();

        // Chart 6: Potential Winners (Top 3 consistency)
        $potentialWinners = DB::table('internship_evaluations')
            ->join('moora_sessions', 'internship_evaluations.moora_session_id', '=', 'moora_sessions.id')
            ->join('internships', 'internship_evaluations.internship_id', '=', 'internships.id')
            ->select('internships.name', DB::raw('count(*) as top_appearance'))
            // Logic to find internships with high total scores or ranks in their sessions
            // For simplicity in this dummy environment, we'll use a count of appearances in calculations
            ->groupBy('internships.id', 'internships.name')
            ->orderBy('top_appearance', 'desc')->limit(5)->get();

        $categoryDist = Internship::with('category')
            ->select('category_id', DB::raw('count(*) as count'))
            ->groupBy('category_id')->get()
            ->map(fn($i) => (object)['category' => $i->category->name ?? 'Unknown', 'count' => $i->count]);

        $latest_users = User::where('role', 'user')->latest()->limit(5)->get();
        $latest_sessions = MooraSession::with('user')->latest()->limit(5)->get();
        $latest_logs = \App\Models\ActivityLog::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'latest_users', 'latest_sessions', 'categoryDist', 
            'sessionTrend', 'registrationTrends', 'topCompared', 
            'criteriaWeights', 'topWinners', 'potentialWinners', 'topUserContributions',
            'latest_logs'
        ));
    }
}
