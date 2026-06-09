<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use App\Models\Criteria;
use App\Models\InternshipEvaluation;
use App\Models\MooraSession;
use App\Models\ActivityLog;
use App\Services\MooraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $mooraService;

    public function __construct(MooraService $mooraService)
    {
        $this->mooraService = $mooraService;
    }

    public function index()
    {
        $user = Auth::user();

        // Fail-safe: Redirect admins to their panel if they land here
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 1. Get the latest evaluations session (most recent timestamp)
        $latestEval = DB::table('internship_evaluations')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $bestInternshipData = null;
        $evaluationsCount = 0;
        $personalChartData = [];

        if ($latestEval) {
            // Find all internships evaluated in the same "session" (within 2 seconds of the latest evaluation)
            $sessionTime = Carbon::parse($latestEval->created_at);
            $allEvaluations = DB::table('internship_evaluations')
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [
                    $sessionTime->copy()->subSeconds(2), 
                    $sessionTime->copy()->addSeconds(2)
                ])
                ->get();
            
            $groupedByInternship = $allEvaluations->groupBy('internship_id');
            $evaluationsCount = $groupedByInternship->count();
            
            $criteriaIds = $allEvaluations->pluck('criteria_id')->unique();
            $weights = DB::table('user_criteria_weights')
                ->where('user_id', $user->id)
                ->whereIn('criteria_id', $criteriaIds)
                ->get()
                ->keyBy('criteria_id');
            
            $criteriaModels = Criteria::whereIn('id', $criteriaIds)->get();

            // Prepare data for MOORA
            $mooraAlternatives = [];
            foreach ($groupedByInternship as $iId => $evals) {
                $internship = Internship::find($iId);
                if (!$internship) continue;
                
                $altScores = [];
                foreach ($evals as $e) {
                    $altScores[$e->criteria_id] = $e->score;
                }
                $mooraAlternatives[] = [
                    'id' => $iId,
                    'name' => $internship->name,
                    'scores' => $altScores
                ];
            }

            $mooraCriteria = [];
            foreach ($criteriaModels as $c) {
                $mooraCriteria[] = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'type' => $c->type,
                    'weight' => $weights[$c->id]->weight ?? 0
                ];
            }

            // Run MOORA ranking
            $mooraResults = $this->mooraService->calculate($mooraAlternatives, $mooraCriteria);

            if (!empty($mooraResults)) {
                $winner = $mooraResults[0];
                $winnerInternship = Internship::with('category')->find($winner['id']);
                
                // Mock the internship data for the view
                $bestInternshipData = (object) [
                    'id' => $winner['id'],
                    'name' => $winner['name'],
                    'category' => $winnerInternship->category->name ?? 'Umum',
                    'avg_score' => collect($winner['scores'])->avg(),
                    'optimization_value' => $winner['optimization_value']
                ];

                // 2. Personal Evaluation Profile (Radar)
                $labels = [];
                $values = [];
                foreach ($criteriaModels as $c) {
                    $score = $winner['scores'][$c->id] ?? 0;
                    $labels[] = $c->name;
                    
                    // Logic: If Benefit, score 5 = 5. If Cost, score 1 = 5 (Inverted)
                    if (strtolower($c->type) === 'cost') {
                        $values[] = 6 - $score;
                    } else {
                        $values[] = $score;
                    }
                }

                $personalChartData = [
                    'labels' => $labels,
                    'values' => $values,
                ];

                // Update avg_score to be the average of the radar values (with inverted cost)
                $bestInternshipData->avg_score = collect($values)->avg();
            }
        }

        // 3. Global Stats
        $totalUsers = User::count();
        $totalInternships = Internship::whereNull('user_id')->count();
        $totalSessions = MooraSession::where('user_id', $user->id)->count();
        
        // 4. Latest Sessions
        $latestSessions = MooraSession::where('user_id', $user->id)
            ->with(['evaluations.internship.category'])
            ->latest()
            ->limit(5)
            ->get();

        // 5. Popular Criteria
        $allSessions = MooraSession::where('user_id', $user->id)->get();
        $criteriaCounts = [];
        foreach ($allSessions as $s) {
            foreach ($s->criteria_used as $cId) {
                $criteriaCounts[$cId] = ($criteriaCounts[$cId] ?? 0) + 1;
            }
        }
        arsort($criteriaCounts);
        $topCriteriaIds = array_slice(array_keys($criteriaCounts), 0, 6, true);
        $popularCriteria = Criteria::whereIn('id', $topCriteriaIds)->get()->map(function($c) use ($criteriaCounts, $totalSessions) {
            $count = $criteriaCounts[$c->id] ?? 0;
            return (object) [
                'name' => $c->name,
                'count' => $count,
                'percentage' => $totalSessions > 0 ? round(($count / $totalSessions) * 100) : 0
            ];
        })->sortByDesc('count');

        // 6. Recent Activities
        $recentActivities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->limit(4)
            ->get();

        $criterias = Criteria::all();

        return view('dashboard', compact(
            'evaluationsCount', 
            'bestInternshipData', 
            'personalChartData',
            'totalUsers', 
            'totalInternships',
            'totalSessions',
            'latestSessions',
            'popularCriteria',
            'criterias'
        ));
    }
}
