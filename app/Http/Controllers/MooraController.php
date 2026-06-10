<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Internship;
use App\Models\UserCriteriaWeight;
use App\Models\InternshipEvaluation;
use App\Models\MooraSession;
use App\Services\MooraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Show ONLY user's own internships for calculation
        $internships = Internship::where('user_id', Auth::id())
                                 ->with('category')
                                 ->get();
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

        $totalWeight = array_sum(array_intersect_key($weights, array_flip($selectedCriteriaIds)));
        if (abs($totalWeight - 100) > 0.01) {
            return back()->withErrors(['weights' => 'Total bobot harus tepat 100%. Sekarang: ' . $totalWeight . '%'])->withInput();
        }

        // Tetap simpan sebagai preferensi terakhir di form (opsional, untuk kenyamanan user)
        foreach ($selectedCriteriaIds as $cId) {
            UserCriteriaWeight::updateOrCreate(
                ['user_id' => Auth::id(), 'criteria_id' => $cId],
                ['weight' => $weights[$cId]]
            );
        }

        $mooraCriteria = [];
        $sessionWeightsData = []; // Array untuk menyimpan ID Kriteria sekaligus Bobotnya di Sesi ini
        
        $criterias = Criteria::whereIn('id', $selectedCriteriaIds)->get();
        foreach ($criterias as $c) {
            $sessionWeightsData[$c->id] = (float) $weights[$c->id]; // Simpan bobot
            $mooraCriteria[] = [
                'id' => $c->id,
                'name' => $c->name,
                'type' => strtolower($c->type), // Ambil type dari database (Benefit/Cost)
                'weight' => (float) $weights[$c->id]
            ];
        }

        $mooraAlternatives = [];
        foreach ($selectedInternshipIds as $iId) {
            $internship = Internship::find($iId);
            $altScores = [];
            foreach ($selectedCriteriaIds as $cId) {
                $altScores[$cId] = (float) $scores[$iId][$cId];
            }
            $mooraAlternatives[] = [
                'id' => $internship->id,
                'name' => $internship->name,
                'scores' => $altScores
            ];
        }

        $results = $this->mooraService->calculate($mooraAlternatives, $mooraCriteria);

        // Simpan Data Bobot Per Sesi ke dalam JSON `criteria_used`
        $session = MooraSession::create([
            'user_id' => Auth::id(),
            'winner_name' => !empty($results) ? $results[0]['name'] : null,
            'max_optimization_value' => !empty($results) ? $results[0]['optimization_value'] : null,
            'criteria_used' => $sessionWeightsData, 
        ]);

        foreach ($results as &$res) {
            $res['original_scores'] = [];
            foreach ($selectedCriteriaIds as $cId) {
                $scoreValue = $scores[$res['id']][$cId];
                $res['original_scores'][$cId] = $scoreValue;

                InternshipEvaluation::create([
                    'user_id' => Auth::id(), 
                    'internship_id' => $res['id'], 
                    'criteria_id' => $cId,
                    'score' => $scoreValue,
                    'moora_session_id' => $session->id 
                ]);
            }
        }

        // Ambil ulang kriteria agar bersih (hanya yang terpilih)
        $criterias = Criteria::whereIn('id', $selectedCriteriaIds)->get();
        foreach ($criterias as $c) {
            $c->weight = $weights[$c->id];
        }

        return view('moora.results', compact('results', 'criterias'));
    }

    public function history(Request $request)
    {
        $query = MooraSession::where('user_id', Auth::id())
            ->with(['evaluations.internship.category', 'evaluations.criteria'])
            ->latest();

        if ($request->filter === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        if ($request->search) {
            $query->where('winner_name', 'like', '%' . $request->search . '%');
        }

        if ($request->sort === 'oldest') {
            $query->reorder('created_at', 'asc');
        }

        $sessions = $query->paginate(8)->withQueryString();

        $totalSessionsCount = MooraSession::where('user_id', Auth::id())->count();
        $latestSession = MooraSession::where('user_id', Auth::id())->latest()->first();
        $avgAlternatifs = MooraSession::where('user_id', Auth::id())->with('evaluations')->get()->map(function($s) {
            return $s->evaluations->groupBy('internship_id')->count();
        })->avg() ?? 0;

        $formattedSessions = collect($sessions->items())->map(function ($session) {
            $evaluations = $session->evaluations;
            $grouped = $evaluations->groupBy('internship_id');
            
            $sessionWeights = $session->criteria_used; 
            $isAssociative = array_keys($sessionWeights) !== range(0, count($sessionWeights) - 1);
            $criteriaIds = $isAssociative ? array_keys($sessionWeights) : $sessionWeights;
            
            // Re-fetch criteria to get correct types from DB (seeder standard)
            $criteriaModels = Criteria::whereIn('id', $criteriaIds)->get()->keyBy('id');
            
            $mooraCriteria = [];
            foreach ($criteriaIds as $cId) {
                $c = $criteriaModels[$cId] ?? null;
                if (!$c) continue;
                $weight = $isAssociative ? ($sessionWeights[$cId] ?? 0) : (100 / count($criteriaIds));
                $mooraCriteria[] = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'type' => strtolower($c->type),
                    'weight' => (float) $weight
                ];
            }

            $mooraAlternatives = [];
            foreach ($grouped as $iId => $evals) {
                $internship = $evals->first()->internship;
                $altScores = [];
                foreach ($evals as $e) {
                    if (in_array($e->criteria_id, $criteriaIds)) {
                        $altScores[$e->criteria_id] = (float) $e->score;
                    }
                }
                $mooraAlternatives[] = [
                    'id' => $iId,
                    'name' => $internship->name ?? 'Unknown',
                    'scores' => $altScores
                ];
            }

            $results = !empty($mooraAlternatives) && !empty($mooraCriteria) 
                ? $this->mooraService->calculate($mooraAlternatives, $mooraCriteria)
                : [];
            
            // Min-Max Scaling for Bars
            $minYi = !empty($results) ? collect($results)->min('optimization_value') : 0;
            $maxYi = !empty($results) ? collect($results)->max('optimization_value') : 0;
            $range = $maxYi - $minYi;

            $firstEval = $evaluations->first();
            
            return [
                'id' => $session->id,
                'winner' => $session->winner_name,
                'category' => $firstEval && $firstEval->internship && $firstEval->internship->category 
                    ? $firstEval->internship->category->name 
                    : 'Umum',
                'score' => (float) $session->max_optimization_value,
                'date' => $session->created_at->format('j M Y'),
                'time' => $session->created_at->format('H:i'),
                'criteriaCount' => count($criteriaIds),
                'altCount' => count($grouped),
                'companies' => collect($results)->map(function($res) use ($maxYi, $minYi, $range) {
                    $percentage = ($range > 0) ? (($res['optimization_value'] - $minYi) / $range) * 100 : 100;
                    return [
                        'name' => $res['name'],
                        'yi' => (float) $res['optimization_value'],
                        'bars' => $percentage
                    ];
                })->toArray(),
                'criteria' => collect($mooraCriteria)->map(function($c) {
                    return [
                        'name' => $c['name'],
                        'weight' => $c['weight'],
                        'type' => $c['type']
                    ];
                })->toArray()
            ];
        });

        return view('moora.history', compact('sessions', 'formattedSessions', 'totalSessionsCount', 'latestSession', 'avgAlternatifs'));
    }

    public function showHistory(MooraSession $session)
    {
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }

        $session->load(['evaluations.internship.category', 'evaluations.criteria']);
        $evaluations = $session->evaluations;
        $grouped = $evaluations->groupBy('internship_id');
        
        $sessionWeights = $session->criteria_used; 
        $isAssociative = array_keys($sessionWeights) !== range(0, count($sessionWeights) - 1);
        $criteriaIds = $isAssociative ? array_keys($sessionWeights) : $sessionWeights;
        
        $criteriaModels = Criteria::whereIn('id', $criteriaIds)->get()->keyBy('id');
        
        $mooraCriteria = [];
        $displayCriteria = [];
        foreach ($criteriaIds as $cId) {
            $c = $criteriaModels[$cId] ?? null;
            if (!$c) continue;
            $weight = $isAssociative ? ($sessionWeights[$cId] ?? 0) : (100 / count($criteriaIds));
            
            $mooraCriteria[] = [
                'id' => $c->id,
                'name' => $c->name,
                'type' => strtolower($c->type),
                'weight' => (float) $weight
            ];

            $c->weight = $weight;
            $displayCriteria[] = $c;
        }

        $mooraAlternatives = [];
        foreach ($grouped as $iId => $evals) {
            $internship = $evals->first()->internship;
            $altScores = [];
            foreach ($evals as $e) {
                if (in_array($e->criteria_id, $criteriaIds)) {
                    $altScores[$e->criteria_id] = (float) $e->score;
                }
            }
            $mooraAlternatives[] = [
                'id' => $iId,
                'name' => $internship->name ?? 'Unknown',
                'scores' => $altScores
            ];
        }

        $results = $this->mooraService->calculate($mooraAlternatives, $mooraCriteria);
        foreach ($results as &$res) {
            $res['original_scores'] = $res['scores'];
        }
        $criterias = collect($displayCriteria);

        return view('moora.results', compact('results', 'criterias'));
    }

    public function destroySession(MooraSession $session)
    {
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }
        $name = $session->winner_name;
        $session->delete();

        \App\Providers\ActivityLogServiceProvider::log('Deleted', 'MOORA', "Menghapus riwayat analisis: {$name}.");

        return back()->with('success', 'Sesi berhasil dihapus.');
    }
}