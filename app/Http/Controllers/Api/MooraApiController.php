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
use Illuminate\Support\Facades\DB;

class MooraApiController extends Controller
{
    protected $mooraService;

    public function __construct(MooraService $mooraService)
    {
        $this->mooraService = $mooraService;
    }

    /**
     * Get criterias with their 1-5 scale descriptions for "Smart Scoring Guide" in Flutter.
     */
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

    /**
     * Unified calculation: saves weights, scores, and returns results.
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'criteria' => 'required|array|min:3',
            'criteria.*' => 'exists:criterias,id',
            'weights' => 'required|array',
            'weights.*' => 'required|numeric|min:5|max:80',
            'internships' => 'required|array|min:2',
            'internships.*' => [
                'required',
                Rule::exists('internships', 'id')->where(fn($q) => $q->where('user_id', Auth::id()))
            ],
            'scores' => 'required|array',
            'scores.*.*' => 'required|integer|min:1|max:5',
        ]);

        $selectedCriteriaIds = array_keys($request->criteria);
        $weights = $request->weights;
        $selectedInternshipIds = $request->internships;
        $scores = $request->scores;

        // 1. Validate total weight
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

        // 2. Save weights
        foreach ($selectedCriteriaIds as $cId) {
            UserCriteriaWeight::updateOrCreate(
                ['user_id' => Auth::id(), 'criteria_id' => $cId],
                ['weight' => $weights[$cId]]
            );
        }

        // 3. Prepare MOORA data
        $mooraAlternatives = [];
        $mooraCriteria = [];

        $criteriaModels = Criteria::whereIn('id', $selectedCriteriaIds)->get();
        foreach ($criteriaModels as $c) {
            $mooraCriteria[] = [
                'id' => $c->id,
                'name' => $c->name,
                'type' => $c->type,
                'weight' => $weights[$c->id]
            ];
        }

        foreach ($selectedInternshipIds as $iId) {
            $internship = Internship::find($iId);
            if (!$internship || $internship->user_id !== Auth::id()) continue;

            $altScores = [];
            
            // Clean old evaluations for this internship (per user)
            InternshipEvaluation::where('user_id', Auth::id())
                ->where('internship_id', $iId)
                ->delete();

            foreach ($selectedCriteriaIds as $cId) {
                $scoreValue = $scores[$iId][$cId] ?? 1;
                InternshipEvaluation::create([
                    'user_id' => Auth::id(),
                    'internship_id' => $iId,
                    'criteria_id' => $cId,
                    'score' => $scoreValue
                ]);
                $altScores[$cId] = $scoreValue;
            }

            $mooraAlternatives[] = [
                'id' => $internship->id,
                'name' => $internship->name,
                'scores' => $altScores
            ];
        }

        if (count($mooraAlternatives) < 2) {
            return response()->json(['success' => false, 'message' => 'Minimal pilih 2 perusahaan milik Anda.'], 422);
        }

        // 4. Execute MOORA
        $results = $this->mooraService->calculate($mooraAlternatives, $mooraCriteria);

        // 5. Create Session
        $session = MooraSession::create([
            'user_id' => Auth::id(),
            'winner_name' => !empty($results) ? $results[0]['name'] : null,
            'max_optimization_value' => !empty($results) ? $results[0]['optimization_value'] : null,
            'criteria_used' => $selectedCriteriaIds,
        ]);

        // 6. Link evaluations to session
        InternshipEvaluation::where('user_id', Auth::id())
            ->whereIn('internship_id', $selectedInternshipIds)
            ->whereIn('criteria_id', $selectedCriteriaIds)
            ->whereNull('moora_session_id')
            ->update(['moora_session_id' => $session->id]);

        return response()->json([
            'success' => true,
            'message' => 'Perhitungan MOORA berhasil.',
            'session_id' => $session->id,
            'data' => $results,
            'criterias' => $criteriaModels // Send criteria for radar chart labels in Flutter
        ]);
    }
}
