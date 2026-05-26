<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use App\Models\Criteria;
use App\Models\InternshipEvaluation;
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
                
                // Mock the internship data for the view
                $bestInternshipData = (object) [
                    'id' => $winner['id'],
                    'name' => $winner['name'],
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
        $totalInternships = Internship::count();
        
        // 4. Treemap Data
        $treemapData = Internship::select('category', DB::raw('count(*) as value'))
            ->groupBy('category')
            ->orderBy('value', 'desc')
            ->get();

        // 5. Growth Trend Data: Last 1 Year, grouped by 2 Months
        $registrationTrends = collect();
        $now = Carbon::now();
        // Go back 12 months, steps of 2 months
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i * 2);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();
            
            // Count new users in this specific period to create a non-monotonic trend
            $count = User::whereBetween('created_at', [$start, $end])->count();
            
            $registrationTrends->push([
                'label' => $date->format('M Y'),
                'count' => $count
            ]);
        }

        // 6. Benchmark Data
        $top5Categories = Internship::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->pluck('category');

        $criterias = Criteria::all();
        $criteriaIds = $criterias->pluck('id');

        $allAverages = DB::table('internship_evaluations')
            ->join('internships', 'internship_evaluations.internship_id', '=', 'internships.id')
            ->whereIn('internships.category', $top5Categories)
            ->whereIn('internship_evaluations.criteria_id', $criteriaIds)
            ->select('internships.category', 'internship_evaluations.criteria_id', DB::raw('AVG(score) as avg_score'))
            ->groupBy('internships.category', 'internship_evaluations.criteria_id')
            ->get()
            ->groupBy('category');

        $criteriaComparison = [];
        foreach ($top5Categories as $cat) {
            $catScores = [];
            $catData = $allAverages->get($cat) ? $allAverages->get($cat)->keyBy('criteria_id') : collect();
            foreach ($criterias as $crit) {
                $score = $catData->get($crit->id);
                $catScores[] = $score ? round($score->avg_score, 2) : null;
            }
            $criteriaComparison[] = [
                'label' => $cat,
                'data' => $catScores
            ];
        }

        // 7. Global Top Ranking
        $globalTopInternships = DB::table('internships')
            ->join('internship_evaluations', 'internships.id', '=', 'internship_evaluations.internship_id')
            ->select('internships.name', DB::raw('AVG(internship_evaluations.score) as avg_score'), 'internships.category')
            ->groupBy('internships.name', 'internships.category')
            ->orderBy('avg_score', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'evaluationsCount', 
            'bestInternshipData', 
            'personalChartData',
            'totalUsers', 
            'totalInternships',
            'treemapData',
            'registrationTrends',
            'criteriaComparison',
            'criterias',
            'globalTopInternships'
        ));
    }
}
