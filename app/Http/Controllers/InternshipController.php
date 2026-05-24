<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\Criteria;
use App\Models\InternshipEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Auth::user()->internships()->latest()->get();
        return view('internships.index', compact('internships'));
    }

    public function create()
    {
        $categories = [
            'Software House', 'Fintech Startup', 'E-commerce', 'Edutech', 'Healthtech', 
            'Banking & Finance', 'Oil & Gas', 'Telecommunications', 'FMCG', 'Manufacturing', 
            'Automotive', 'Lembaga Negara', 'BUMN', 'Media & Broadcasting', 'Game Development', 
            'Creative Agency', 'Logistics', 'Agriculture Tech', 'Cyber Security', 'Cloud Service', 
            'Venture Capital', 'Retail', 'Hospitality', 'Aviation'
        ];
        sort($categories); // Sort alphabetically for better UX

        // Fetch all unique internships from other users to suggest
        $globalInternships = Internship::select('name', 'city', 'category', 'description')
            ->where('user_id', '!=', Auth::id())
            ->groupBy('name', 'city', 'category', 'description')
            ->get();

        $indonesianCities = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Bekasi', 'Depok', 'Tangerang', 'Palembang', 'Semarang', 'Makassar',
            'South Tangerang', 'Batam', 'Bandar Lampung', 'Bogor', 'Padang', 'Malang', 'Pekanbaru', 'Denpasar', 'Samarinda',
            'Tasikmalaya', 'Pontianak', 'Banjarmasin', 'Balikpapan', 'Jambi', 'Cilegon', 'Mataram', 'Manado', 'Yogyakarta'
        ];

        return view('internships.create', compact('categories', 'globalInternships', 'indonesianCities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'use_existing' => 'nullable|boolean'
        ]);

        // Constraint: Check if this user already added this internship (name + city)
        $exists = Auth::user()->internships()
            ->where('name', $validated['name'])
            ->where('city', $validated['city'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Anda sudah menambahkan tempat magang ini sebelumnya di kota yang sama.'])
                        ->withInput();
        }

        Auth::user()->internships()->create([
            'name' => $validated['name'],
            'city' => $validated['city'],
            'category' => $validated['category'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil ditambahkan.');
    }

    public function edit(Internship $internship)
    {
        $this->authorize('update', $internship);
        $categories = [
            'Software House', 'Fintech Startup', 'E-commerce', 'Edutech', 'Healthtech', 
            'Banking & Finance', 'Oil & Gas', 'Telecommunications', 'FMCG', 'Manufacturing', 
            'Automotive', 'Lembaga Negara', 'BUMN', 'Media & Broadcasting', 'Game Development', 
            'Creative Agency', 'Logistics', 'Agriculture Tech', 'Cyber Security', 'Cloud Service', 
            'Venture Capital', 'Retail', 'Hospitality', 'Aviation'
        ];
        sort($categories);
        return view('internships.edit', compact('internship', 'categories'));
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

        // Constraint: Check if this user already has another internship with same name + city
        $exists = Auth::user()->internships()
            ->where('name', $validated['name'])
            ->where('city', $validated['city'])
            ->where('id', '!=', $internship->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Nama tempat magang dan kota ini sudah ada dalam daftar Anda.'])
                        ->withInput();
        }

        $internship->update($validated);

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil diperbarui.');
    }

    public function destroy(Internship $internship)
    {
        $this->authorize('delete', $internship);
        $internship->delete();

        return redirect()->route('internships.index')->with('success', 'Tempat magang berhasil dihapus.');
    }
}
