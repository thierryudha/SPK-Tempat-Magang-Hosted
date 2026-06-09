<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $action = $request->input('action');

        $logs = ActivityLog::with('user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($uq) use ($search) {
                          $uq->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($action, function ($query, $action) {
                return $query->where('action', $action);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $actions = ActivityLog::distinct()->pluck('action');

        return view('admin.logs.index', compact('logs', 'actions'));
    }
}
