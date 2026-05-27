<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\UserCriteriaWeight;
use App\Models\InternshipEvaluation;
use App\Models\Internship;
use App\Models\MooraSession;
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

        $totalWeight = 0;
        foreach ($selectedCriteriaIds as $cId) {
            $totalWeight += $weights[$cId] ?? 0;
        }

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
            $internship = Internship::find($iId);
            if (!$internship) continue;

            $altScores = [];
            foreach ($selectedCriteriaIds as $cId) {
                $scoreValue = $scores[$iId][$cId] ?? 1;
                InternshipEvaluation::updateOrCreate(
                    ['user_id' => Auth::id(), 'internship_id' => $iId, 'criteria_id' => $cId],
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

        // Create Session
        $session = MooraSession::create([
            'user_id' => Auth::id(),
            'winner_name' => !empty($results) ? $results[0]['name'] : null,
            'max_optimization_value' => !empty($results) ? $results[0]['optimization_value'] : null,
            'criteria_used' => $selectedCriteriaIds,
        ]);

        // Link evaluations to session
        InternshipEvaluation::where('user_id', Auth::id())
            ->whereIn('internship_id', $selectedInternshipIds)
            ->whereIn('criteria_id', $selectedCriteriaIds)
            ->whereNull('moora_session_id')
            ->update(['moora_session_id' => $session->id]);

        return response()->json([
            'success' => true,
            'session_id' => $session->id,
            'data' => $results
        ]);
    }
}
