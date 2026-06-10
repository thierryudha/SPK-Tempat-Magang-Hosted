<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Criteria;
use App\Models\Category;
use App\Models\InternshipEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::where('user_id', Auth::id())
            ->with('category')
            ->latest()
            ->get();
        return view('internships.index', compact('internships'));
    }

    public function create()
    {
        $categories = Category::all();

        // Fetch all existing internships to show in the UI list if needed
        $globalInternships = Internship::whereNull('user_id')->with('category')->latest()->get();

        return view('internships.create', compact('categories', 'globalInternships'));
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:internships,id',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $global = Internship::find($id);
            
            // Check if user already has it (by name)
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

        \App\Providers\ActivityLogServiceProvider::log('Created', 'Daftar Magang', "Menambahkan {$count} tempat magang dari data global.");

        return redirect()->route('internships.index')->with('success', $count . ' tempat magang berhasil ditambahkan ke daftar Anda.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('internships')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'category_id' => 'required|exists:categories,id',
            'website_link' => 'nullable|url',
        ]);

        $validated['user_id'] = Auth::id();

        $internship = Internship::create($validated);

        \App\Providers\ActivityLogServiceProvider::log('Created', 'Daftar Magang', "Menambah tempat magang mandiri: {$internship->name}.");

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil ditambahkan.');
    }

    public function edit(Internship $internship)
    {
        $this->authorize('update', $internship);

        $categories = Category::all();
        return view('internships.edit', compact('internship', 'categories'));
    }


    public function update(Request $request, Internship $internship)
    {
        $this->authorize('update', $internship);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('internships')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($internship->id),
            ],
            'category_id' => 'required|exists:categories,id',
            'website_link' => 'nullable|url',
        ]);

        $internship->update($validated);

        \App\Providers\ActivityLogServiceProvider::log('Updated', 'Daftar Magang', "Memperbarui tempat magang: {$internship->name}.");

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil diperbarui.');
    }

    public function destroy(Internship $internship)
    {
        $this->authorize('delete', $internship);

        $name = $internship->name;
        $internship->delete();

        \App\Providers\ActivityLogServiceProvider::log('Deleted', 'Daftar Magang', "Menghapus tempat magang: {$name}.");

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil dihapus.');
    }
}
