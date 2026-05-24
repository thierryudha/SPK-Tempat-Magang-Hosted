<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Internship;
use App\Models\UserCriteriaWeight;
use App\Models\InternshipEvaluation;
use App\Services\MooraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MooraController extends Controller
{
    protected $mooraService;

    public function __construct(MooraService $mooraService)
    {
        $this->mooraService = $mooraService;
    }

    public function index()
    {
        $criterias = Criteria::with('scales')->get();
        $internships = Auth::user()->internships;
        $userWeights = Auth::user()->weights->pluck('weight', 'criteria_id');

        return view('moora.index', compact('criterias', 'internships', 'userWeights'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'criteria' => 'required|array|min:3',
            'weights' => 'required|array',
            'internships' => 'required|array|min:1',
            'scores' => 'required|array',
        ]);

        $selectedCriteriaIds = array_keys($request->criteria);
        $weights = $request->weights;
        $selectedInternshipIds = $request->internships;
        $scores = $request->scores;

        // Verify total weight is 100%
        $totalWeight = array_sum(array_intersect_key($weights, array_flip($selectedCriteriaIds)));
        if (abs($totalWeight - 100) > 0.01) {
            return back()->withErrors(['weights' => 'Total bobot harus tepat 100%. Sekarang: ' . $totalWeight . '%'])->withInput();
        }

        // Save weights to DB
        foreach ($selectedCriteriaIds as $cId) {
            UserCriteriaWeight::updateOrCreate(
                ['user_id' => Auth::id(), 'criteria_id' => $cId],
                ['weight' => $weights[$cId]]
            );
        }

        // Save scores and prepare data for MOORA
        $mooraAlternatives = [];
        $mooraCriteria = [];

        $criterias = Criteria::whereIn('id', $selectedCriteriaIds)->get();
        foreach ($criterias as $c) {
            $mooraCriteria[] = [
                'id' => $c->id,
                'name' => $c->name,
                'type' => $c->type,
                'weight' => $weights[$c->id]
            ];
        }

        foreach ($selectedInternshipIds as $iId) {
            $internship = Internship::find($iId);
            $altScores = [];
            foreach ($selectedCriteriaIds as $cId) {
                $scoreValue = $scores[$iId][$cId];
                InternshipEvaluation::updateOrCreate(
                    ['internship_id' => $iId, 'criteria_id' => $cId],
                    ['score' => $scoreValue]
                );
                $altScores[$cId] = $scoreValue;
            }

            $mooraAlternatives[] = [
                'id' => $internship->id,
                'name' => $internship->name,
                'scores' => $altScores
            ];
        }

        $results = $this->mooraService->calculate($mooraAlternatives, $mooraCriteria);

        return view('moora.results', compact('results', 'criterias'));
    }
}
