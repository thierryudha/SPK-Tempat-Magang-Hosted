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

        // 1. Get the latest MOORA session
        $latestSession = MooraSession::where('user_id', $user->id)
            ->with(['evaluations.internship.category', 'evaluations.criteria'])
            ->latest()
            ->first();

        $bestInternshipData = null;
        $evaluationsCount = 0;
        $personalChartData = [];

        if ($latestSession) {
            $evaluations = $latestSession->evaluations;
            $grouped = $evaluations->groupBy('internship_id');
            $evaluationsCount = $grouped->count();

            // Find the winner from evaluations
            $winnerInternship = null;
            $winnerEvaluations = collect();

            foreach ($grouped as $internshipId => $evs) {
                $internship = $evs->first()->internship;
                // Since winner_name is stored in session, we match by name
                if ($internship && $internship->name === $latestSession->winner_name) {
                    $winnerInternship = $internship;
                    $winnerEvaluations = $evs;
                    break;
                }
            }

            // Fallback if name matching fails (rare)
            if (!$winnerInternship && $grouped->isNotEmpty()) {
                $winnerEvaluations = $grouped->first();
                $winnerInternship = $winnerEvaluations->first()->internship;
            }

            if ($winnerInternship) {
                $bestInternshipData = (object) [
                    'id' => $winnerInternship->id,
                    'name' => $winnerInternship->name,
                    'category' => $winnerInternship->category->name ?? 'Umum',
                    'optimization_value' => $latestSession->max_optimization_value
                ];

                // Radar Chart Data
                $labels = [];
                $values = [];
                foreach ($winnerEvaluations as $ev) {
                    $labels[] = $ev->criteria->name;
                    $score = $ev->score;
                    
                    // Logic from Seeder:
                    // Benefit: C1, C4, C5, C6, C7, C8, C9
                    // Cost: C2 (Jam Kerja), C3 (Jarak), C10 (Beban Tugas)
                    // Visualization logic: Invert Cost so higher point on radar is always "better"
                    if (strtolower($ev->criteria->type) === 'cost') {
                        $values[] = 6 - $score;
                    } else {
                        $values[] = $score;
                    }
                }

                $personalChartData = [
                    'labels' => $labels,
                    'values' => $values,
                ];

                $bestInternshipData->avg_score = !empty($values) ? collect($values)->avg() : 0;
            }
        }

        // 2. Global Stats
        $totalUsers = User::count();
        $totalInternships = Internship::whereNull('user_id')->count();
        $totalSessions = MooraSession::where('user_id', $user->id)->count();
        
        // 3. Latest Sessions (Enhanced for View)
        $latestSessionsRaw = MooraSession::where('user_id', $user->id)
            ->with(['evaluations.internship.category'])
            ->latest()
            ->limit(5)
            ->get();

        $latestSessions = $latestSessionsRaw->map(function($session) {
            $evals = $session->evaluations;
            $firstEval = $evals->first();
            $altCount = $evals->isNotEmpty() ? $evals->groupBy('internship_id')->count() : 0;
            
            return (object) [
                'id' => $session->id,
                'winner_name' => $session->winner_name,
                'created_at' => $session->created_at,
                'max_optimization_value' => $session->max_optimization_value,
                'alt_count' => $altCount,
                'criteria_count' => count($session->criteria_used ?? []),
                'category' => ($firstEval && $firstEval->internship && $firstEval->internship->category) 
                    ? $firstEval->internship->category->name 
                    : 'Umum'
            ];
        });

        // 4. Popular Criteria
        $criteriaCounts = [];
        $allSessionsCriteria = MooraSession::where('user_id', $user->id)->get(['criteria_used']);
        
        foreach ($allSessionsCriteria as $s) {
            $used = $s->criteria_used;
            if (is_array($used)) {
                // Handle both associative (id => weight) and sequential (id)
                $isAssociative = array_keys($used) !== range(0, count($used) - 1);
                $ids = $isAssociative ? array_keys($used) : $used;
                foreach ($ids as $cId) {
                    $criteriaCounts[$cId] = ($criteriaCounts[$cId] ?? 0) + 1;
                }
            }
        }
        
        arsort($criteriaCounts);
        $topCriteriaIds = array_slice(array_keys($criteriaCounts), 0, 6);
        $popularCriteria = Criteria::whereIn('id', $topCriteriaIds)->get()->map(function($c) use ($criteriaCounts, $totalSessions) {
            $count = $criteriaCounts[$c->id] ?? 0;
            return (object) [
                'name' => $c->name,
                'count' => $count,
                'percentage' => $totalSessions > 0 ? round(($count / $totalSessions) * 100) : 0
            ];
        })->sortByDesc('count');

        // 5. Recent Activities
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
            'criterias',
            'recentActivities'
        ));
    }
}
