<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class UserInternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::with(['user', 'category'])
            ->whereNotNull('user_id')
            ->latest()
            ->get();

        return view('admin.user-internships.index', compact('internships'));
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
