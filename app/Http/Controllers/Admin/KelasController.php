<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $items = Kelas::with('jurusan')->latest()->get();
        $jurusan = Jurusan::all();

        return view('admin.kelas.index', compact('items','jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => 'required',
            'singkatan' => 'required|unique:kelas,singkatan',
            'angkatan' => 'required|digits:4'
        ]);

        Kelas::create([
            'tingkat' => $request->tingkat,
            'jurusan_id' => $request->jurusan_id,
            'rombel' => $request->rombel,
            'singkatan' => $request->singkatan,
            'angkatan' => $request->angkatan
        ]);

        return redirect()->back()->with('success','Kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'rombel' => 'required',
            'singkatan' => 'required|unique:kelas,singkatan,'.$id,
            'angkatan' => 'required|digits:4'
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'tingkat' => $request->tingkat,
            'jurusan_id' => $request->jurusan_id,
            'rombel' => $request->rombel,
            'singkatan' => $request->singkatan,
            'angkatan' => $request->angkatan
        ]);

        return redirect()->back()->with('success','Kelas berhasil diupdate');
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect()->back()->with('success','Kelas berhasil dihapus');
    }
}
