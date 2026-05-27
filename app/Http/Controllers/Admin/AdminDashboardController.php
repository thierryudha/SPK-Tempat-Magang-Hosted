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
            'total_internships' => Internship::count(),
            'total_criterias' => Criteria::count(),
            'total_sessions' => MooraSession::count(),
        ];

        // Chart Data 1: Distribution by Category
        $categoryDist = Internship::with('category')
            ->select('category_id', \DB::raw('count(*) as count'))
            ->groupBy('category_id')
            ->get()
            ->map(function($item) {
                return (object) [
                    'category' => $item->category->name ?? 'Unknown',
                    'count' => $item->count
                ];
            });

        // Chart Data 2: MOORA Activity Trend (Last 7 Days)
        $sessionTrend = MooraSession::select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return (object) [
                    'date' => \Carbon\Carbon::parse($item->date)->format('d M'),
                    'count' => $item->count
                ];
            });

        // Chart Data 3: Registration Growth Trend (Last 6 Months)
        $registrationTrends = collect();
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $count = User::where('role', 'user')
                ->whereMonth('created_at', $monthDate->month)
                ->whereYear('created_at', $monthDate->year)
                ->count();
            
            $registrationTrends->push((object)[
                'label' => $monthDate->format('M Y'),
                'count' => $count
            ]);
        }

        // Chart Data 4: Benchmark Comparison (Restored from User)
        $top5Categories = Internship::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $criterias = Criteria::all();
        $criteriaIds = $criterias->pluck('id');

        $criteriaComparison = [];
        foreach ($top5Categories as $catItem) {
            $catScores = [];
            $categoryName = $catItem->category->name ?? 'Unknown';
            
            $catData = DB::table('internship_evaluations')
                ->join('internships', 'internship_evaluations.internship_id', '=', 'internships.id')
                ->where('internships.category_id', $catItem->category_id)
                ->whereIn('internship_evaluations.criteria_id', $criteriaIds)
                ->select('internship_evaluations.criteria_id', DB::raw('AVG(score) as avg_score'))
                ->groupBy('internship_evaluations.criteria_id')
                ->get()
                ->keyBy('criteria_id');

            foreach ($criterias as $crit) {
                $score = $catData->get($crit->id);
                $catScores[] = $score ? round($score->avg_score, 2) : 0;
            }
            $criteriaComparison[] = [
                'label' => $categoryName,
                'data' => $catScores
            ];
        }

        $latest_users = User::where('role', 'user')->latest()->limit(5)->get();
        $latest_sessions = MooraSession::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'latest_users', 
            'latest_sessions', 
            'categoryDist', 
            'sessionTrend',
            'registrationTrends',
            'criteriaComparison',
            'criterias'
        ));
    }
}
