<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $admins = User::where('role', 'admin')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.administrators.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.administrators.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        \App\Providers\ActivityLogServiceProvider::log('Created', 'Administrator', "Menambah administrator baru: {$admin->name}.");

        return redirect()->route('admin.administrators.index')->with('success', 'Administrator baru berhasil ditambahkan.');
    }

    public function edit(User $administrator)
    {
        if ($administrator->role !== 'admin') abort(404);
        return view('admin.administrators.edit', ['admin' => $administrator]);
    }

    public function update(Request $request, User $administrator)
    {
        if ($administrator->role !== 'admin') abort(404);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $administrator->id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $administrator->update($data);

        \App\Providers\ActivityLogServiceProvider::log('Updated', 'Administrator', "Memperbarui data administrator: {$administrator->name}.");

        return redirect()->route('admin.administrators.index')->with('success', 'Data administrator berhasil diperbarui.');
    }

    public function destroy(User $administrator)
    {
        if ($administrator->role !== 'admin' || $administrator->id === auth()->id()) {
            abort(403, 'Anda tidak bisa menghapus akun ini.');
        }

        $name = $administrator->name;
        $administrator->delete();

        \App\Providers\ActivityLogServiceProvider::log('Deleted', 'Administrator', "Menghapus administrator: {$name}.");

        return redirect()->route('admin.administrators.index')->with('success', 'Administrator berhasil dihapus.');
    }
}
