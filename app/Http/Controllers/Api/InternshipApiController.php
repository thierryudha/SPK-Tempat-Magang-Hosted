<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InternshipApiController extends Controller
{
    public function index()
    {
        $internships = Internship::with('category')->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $internships
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:internships',
            'city' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $internship = Internship::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tempat magang berhasil ditambahkan.',
            'data' => $internship
        ], 201);
    }

    public function show(Internship $internship)
    {
        $this->authorize('view', $internship);
        return response()->json([
            'success' => true,
            'data' => $internship
        ]);
    }

    public function update(Request $request, Internship $internship)
    {
        $this->authorize('update', $internship);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $exists = Auth::user()->internships()
            ->where('name', $validated['name'])
            ->where('city', $validated['city'])
            ->where('id', '!=', $internship->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Nama tempat magang dan kota ini sudah ada dalam daftar Anda.'
            ], 422);
        }

        $internship->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tempat magang berhasil diperbarui.',
            'data' => $internship
        ]);
    }

    public function destroy(Internship $internship)
    {
        $this->authorize('delete', $internship);
        $internship->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tempat magang berhasil dihapus.'
        ]);
    }
}
