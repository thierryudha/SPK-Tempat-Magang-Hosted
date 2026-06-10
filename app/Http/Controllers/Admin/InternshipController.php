<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Category;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $internships = Internship::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('admin.internships.index', compact('internships', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.internships.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:internships',
            'category_id' => 'required|exists:categories,id',
            'website_link' => 'required|url',
        ]);

        $internship = Internship::create($request->all());

        \App\Providers\ActivityLogServiceProvider::log('Created', 'Perusahaan', "Menambah perusahaan global baru: {$internship->name}.");

        return redirect()->route('admin.internships.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function edit(Internship $internship)
    {
        $categories = Category::all();
        return view('admin.internships.edit', compact('internship', 'categories'));
    }

    public function update(Request $request, Internship $internship)
    {
        $request->validate([
            'name' => 'required|unique:internships,name,' . $internship->id,
            'category_id' => 'required|exists:categories,id',
            'website_link' => 'required|url',
        ]);

        $internship->update($request->all());

        \App\Providers\ActivityLogServiceProvider::log('Updated', 'Perusahaan', "Memperbarui data perusahaan: {$internship->name}.");

        return redirect()->route('admin.internships.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy(Internship $internship)
    {
        $name = $internship->name;
        $internship->delete();

        \App\Providers\ActivityLogServiceProvider::log('Deleted', 'Perusahaan', "Menghapus perusahaan: {$name}.");

        return redirect()->route('admin.internships.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
