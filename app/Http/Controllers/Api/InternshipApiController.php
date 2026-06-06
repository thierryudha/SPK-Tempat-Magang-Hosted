<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InternshipApiController extends Controller
{
    /**
     * Get user's personal internships.
     */
    public function index()
    {
        $internships = Internship::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $internships
        ]);
    }

    /**
     * Get global internships for suggestions.
     */
    public function global()
    {
        $internships = Internship::with('category')
            ->whereNull('user_id')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $internships
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('internships')->where(fn ($q) => $q->where('user_id', Auth::id()))
            ],
            'category_id' => 'required|exists:categories,id',
            'website_link' => 'nullable|url:http,https',
        ]);

        $validated['user_id'] = Auth::id();
        $internship = Internship::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tempat magang berhasil ditambahkan.',
            'data' => $internship->load('category')
        ], 201);
    }

    public function show(Internship $internship)
    {
        if ($internship->user_id !== Auth::id() && $internship->user_id !== null) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $internship->load('category')
        ]);
    }

    public function update(Request $request, Internship $internship)
    {
        if ($internship->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('internships')->where(fn ($q) => $q->where('user_id', Auth::id()))->ignore($internship->id)
            ],
            'category_id' => 'required|exists:categories,id',
            'website_link' => 'nullable|url',
        ]);

        $internship->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tempat magang berhasil diperbarui.',
            'data' => $internship->load('category')
        ]);
    }

    public function destroy(Internship $internship)
    {
        if ($internship->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $internship->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tempat magang berhasil dihapus.'
        ]);
    }

    /**
     * Copy global internships to user list.
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:internships,id',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $global = Internship::find($id);
            if (!$global->user_id) {
                $exists = Internship::where('user_id', Auth::id())
                    ->where('name', $global->name)
                    ->exists();

                if (!$exists) {
                    Internship::create([
                        'name' => $global->name,
                        'category_id' => $global->category_id,
                        'website_link' => $global->website_link,
                        'user_id' => Auth::id(),
                    ]);
                    $count++;
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => "$count tempat magang berhasil ditambahkan ke daftar Anda."
        ]);
    }
}
