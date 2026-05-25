<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use App\Models\Criteria;
use App\Models\InternshipEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Personal Stats
        $myEvaluatedIds = DB::table('internship_evaluations')
            ->where('user_id', $user->id)
            ->distinct()
            ->pluck('internship_id');
        
        $myInternshipsCount = $myEvaluatedIds->count();

        $bestInternshipData = DB::table('internships')
            ->join('internship_evaluations', 'internships.id', '=', 'internship_evaluations.internship_id')
            ->select('internships.*', DB::raw('AVG(internship_evaluations.score) as avg_score'))
            ->where('internship_evaluations.user_id', $user->id)
            ->groupBy('internships.id', 'internships.name', 'internships.city', 'internships.category', 'internships.description', 'internships.created_at', 'internships.updated_at')
            ->orderBy('avg_score', 'desc')
            ->first();

        // 2. Personal Evaluation Profile (Radar)
        $personalChartData = [];
        if ($bestInternshipData) {
            $evaluations = DB::table('internship_evaluations')
                ->join('criterias', 'internship_evaluations.criteria_id', '=', 'criterias.id')
                ->where('internship_evaluations.internship_id', $bestInternshipData->id)
                ->where('internship_evaluations.user_id', $user->id)
                ->where('internship_evaluations.score', '>', 0)
                ->select('criterias.name', 'internship_evaluations.score')
                ->get();
            
            $personalChartData = [
                'labels' => $evaluations->pluck('name'),
                'values' => $evaluations->pluck('score'),
            ];
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
            
            $count = User::where('created_at', '<=', $end)->count();
            
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
            'myInternshipsCount', 
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
