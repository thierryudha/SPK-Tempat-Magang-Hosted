<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::all();
        return view('admin.criterias.index', compact('criterias'));
    }

    public function create()
    {
        return view('admin.criterias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:benefit,cost',
            'scales' => 'required|array|min:5|max:5',
            'scales.*' => 'required|string',
        ]);

        $nextNumber = Criteria::count() + 1;
        
        $criteria = Criteria::create([
            'code' => 'C' . $nextNumber,
            'name' => $request->name,
            'type' => $request->type,
        ]);

        foreach ($request->scales as $score => $description) {
            $criteria->scales()->create([
                'score' => $score,
                'description' => $description,
            ]);
        }

        \App\Providers\ActivityLogServiceProvider::log('Created', 'Kriteria', "Menambah kriteria baru: {$criteria->name}.");

        return redirect()->route('admin.criterias.index')->with('success', 'Kriteria dan skala berhasil ditambahkan.');
    }

    public function edit(Criteria $criteria)
    {
        $criteria->load('scales');
        return view('admin.criterias.edit', compact('criteria'));
    }

    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:benefit,cost',
            'scales' => 'required|array|min:5|max:5',
            'scales.*' => 'required|string',
        ]);

        $criteria->update($request->only(['name', 'type']));

        foreach ($request->scales as $score => $description) {
            $criteria->scales()->updateOrCreate(
                ['score' => $score],
                ['description' => $description]
            );
        }

        \App\Providers\ActivityLogServiceProvider::log('Updated', 'Kriteria', "Memperbarui kriteria: {$criteria->name}.");

        return redirect()->route('admin.criterias.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Criteria $criteria)
    {
        $name = $criteria->name;
        $criteria->delete();

        // Re-generate codes for all criteria to ensure no gaps
        $allCriteria = Criteria::orderBy('id')->get();
        foreach ($allCriteria as $index => $c) {
            $c->update(['code' => 'C' . ($index + 1)]);
        }

        \App\Providers\ActivityLogServiceProvider::log('Deleted', 'Kriteria', "Menghapus kriteria: {$name}.");

        return redirect()->route('admin.criterias.index')->with('success', 'Kriteria berhasil dihapus dan kode telah diperbarui.');
    }
}
