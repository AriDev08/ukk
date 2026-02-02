<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $items = Siswa::with('kelas.jurusan')->latest()->get();
        $kelas = Kelas::with('jurusan')->get();

        return view('admin.siswa.index', compact('items','kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'email' => 'nullable|email'
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'email' => $request->email
        ]);

        return redirect()->back()->with('success','Siswa berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis,'.$id,
            'nama' => 'required',
            'kelas_id' => 'required|exists:kelas,id',
            'email' => 'nullable|email'
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'email' => $request->email
        ]);

        return redirect()->back()->with('success','Siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        Siswa::findOrFail($id)->delete();
        return redirect()->back()->with('success','Siswa berhasil dihapus');
    }
}
