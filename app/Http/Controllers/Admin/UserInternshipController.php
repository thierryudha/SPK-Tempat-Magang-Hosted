<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserInternshipController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');

        $globalNames = Internship::whereNull('user_id')->pluck('name')->map(fn($n) => strtolower($n))->toArray();

        $internships = Internship::with(['user', 'category'])
            ->whereNotNull('user_id')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($status, function ($query, $status) use ($globalNames) {
                if ($status === 'global') {
                    return $query->whereIn(DB::raw('LOWER(name)'), $globalNames);
                } elseif ($status === 'new') {
                    return $query->whereNotIn(DB::raw('LOWER(name)'), $globalNames);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('admin.user-internships.index', compact('internships', 'categories', 'globalNames'));
    }

    public function promote(Internship $internship)
    {
        if (!$internship->website_link) {
            return back()->with('error', 'Perusahaan harus memiliki Link Website sebelum dijadikan Data Global.');
        }

        $oldName = $internship->name;
        $internship->update(['user_id' => null]);

        \App\Providers\ActivityLogServiceProvider::log('Promoted', 'Kontribusi', "Menjadikan {$oldName} sebagai Data Global.");

        return redirect()->route('admin.user-internships.index')
            ->with('success', "{$internship->name} telah berhasil dijadikan Data Global.");
    }
}
