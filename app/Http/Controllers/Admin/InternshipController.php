<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Category;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::with('category')->get();
        return view('admin.internships.index', compact('internships'));
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

        Internship::create($request->all());
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
        return redirect()->route('admin.internships.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy(Internship $internship)
    {
        $internship->delete();
        return redirect()->route('admin.internships.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
