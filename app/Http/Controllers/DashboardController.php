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
        $myInternshipsCount = $user->internships()->count();
        $bestInternshipData = DB::table('internships')
            ->join('internship_evaluations', 'internships.id', '=', 'internship_evaluations.internship_id')
            ->select('internships.*', DB::raw('AVG(internship_evaluations.score) as avg_score'))
            ->where('internships.user_id', $user->id)
            ->groupBy('internships.id', 'internships.user_id', 'internships.name', 'internships.city', 'internships.category', 'internships.description', 'internships.created_at', 'internships.updated_at')
            ->orderBy('avg_score', 'desc')
            ->first();

        // 2. Personal Evaluation Profile (Radar)
        $personalChartData = [];
        if ($bestInternshipData) {
            $evaluations = DB::table('internship_evaluations')
                ->join('criterias', 'internship_evaluations.criteria_id', '=', 'criterias.id')
                ->where('internship_evaluations.internship_id', $bestInternshipData->id)
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
        
        // 4. Treemap Data: Industry Distribution (Count of Internships per Category)
        $treemapData = Internship::select('category', DB::raw('count(*) as value'))
            ->groupBy('category')
            ->orderBy('value', 'desc')
            ->get();

        // 5. Area Chart Data: Registration Trends (Last 7 days)
        $registrationTrends = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 6. Multi-Line Chart: Average Scores per Criteria over 5 Categories
        $top5Categories = Internship::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->pluck('category');

        $criterias = Criteria::all();
        $criteriaIds = $criterias->pluck('id');

        // Optimized single query for all averages
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
