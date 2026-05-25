<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\UserCriteriaWeight;
use App\Models\InternshipEvaluation;
use App\Services\MooraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MooraApiController extends Controller
{
    protected $mooraService;

    public function __construct(MooraService $mooraService)
    {
        $this->mooraService = $mooraService;
    }

    public function getCriterias()
    {
        $criterias = Criteria::with('scales')->get();
        return response()->json([
            'success' => true,
            'data' => $criterias
        ]);
    }

    public function getUserWeights()
    {
        $weights = Auth::user()->weights->pluck('weight', 'criteria_id');
        return response()->json([
            'success' => true,
            'data' => $weights
        ]);
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

        $totalWeight = array_sum(array_intersect_key($weights, array_flip($selectedCriteriaIds)));
        if (abs($totalWeight - 100) > 0.01) {
            return response()->json([
                'success' => false,
                'message' => 'Total bobot harus tepat 100%. Sekarang: ' . $totalWeight . '%'
            ], 422);
        }

        foreach ($selectedCriteriaIds as $cId) {
            UserCriteriaWeight::updateOrCreate(
                ['user_id' => Auth::id(), 'criteria_id' => $cId],
                ['weight' => $weights[$cId]]
            );
        }

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
            $internship = Auth::user()->internships()->find($iId);
            if (!$internship) continue;

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

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
}
