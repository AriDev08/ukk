<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $items = Siswa::with(['kelas.jurusan','user'])
                      ->latest()
                      ->paginate(10);

        return view('admin.siswa.index', compact('items'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')
                      ->orderBy('angkatan')
                      ->get();

        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'       => 'required|unique:siswa,nis',
            'nama'      => 'required',
            'kelas_id'  => 'required|exists:kelas,id',
            'email'     => 'required|email|unique:users,email',
        ]);

        // Buat user dulu
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->nis),
            'role'     => 'siswa'
        ]);

        // Buat siswa
        Siswa::create([
            'user_id'      => $user->id,
            'nis'          => $request->nis,
            'nama_lengkap' => $request->nama,
            'kelas_id'     => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success','Siswa berhasil dibuat. Password awal = NIS');
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis'       => 'required|unique:siswa,nis,'.$id,
            'nama'      => 'required',
            'kelas_id'  => 'required|exists:kelas,id',
            'email'     => 'required|email|unique:users,email,'.$siswa->user_id,
        ]);

        // Update user
        $siswa->user->update([
            'name'  => $request->nama,
            'email' => $request->email,
        ]);

        // Update siswa
        $siswa->update([
            'nis'          => $request->nis,
            'nama_lengkap' => $request->nama,
            'kelas_id'     => $request->kelas_id,
        ]);

        return redirect()->back()->with('success','Siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->user()->delete();
        $siswa->delete();

        return redirect()->back()->with('success','Siswa & akun berhasil dihapus');
    }
}
