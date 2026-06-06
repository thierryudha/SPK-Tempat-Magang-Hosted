<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\MooraSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Latest Calculation Result
        $latestSession = MooraSession::where('user_id', $user->id)
            ->latest()
            ->first();

        // 2. Personal Ranking Summary
        $myInternshipsCount = Internship::where('user_id', $user->id)->count();
        
        // 3. Global Stats for context
        $globalStats = [
            'total_global_companies' => Internship::whereNull('user_id')->count(),
            'total_sectors' => DB::table('categories')->count(),
        ];

        // 4. Activity Logs (User's own)
        $recentSessions = MooraSession::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'photo_url' => $user->photo ? asset('storage/' . $user->photo) : null,
                ],
                'latest_calculation' => $latestSession,
                'summary' => [
                    'my_internships_count' => $myInternshipsCount,
                    'global_stats' => $globalStats,
                ],
                'recent_activity' => $recentSessions
            ]
        ]);
    }
}
