<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->latest()
            ->paginate(10);

        return view('admin.admin-users.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin-users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin'
        ]);

        return redirect()
            ->route('admin.admin-users.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    public function edit(User $admin_user)
    {
        return view('admin.admin-users.edit', [
            'admin' => $admin_user
        ]);
    }

    public function update(Request $request, User $admin_user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $admin_user->id
        ]);

        $data = $request->only('name', 'email');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin_user->update($data);

        return redirect()
            ->route('admin.admin-users.index')
            ->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy(User $admin_user)
    {
        $admin_user->delete();

        return redirect()
            ->route('admin.admin-users.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}
