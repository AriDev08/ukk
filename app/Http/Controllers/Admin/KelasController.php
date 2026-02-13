<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
      
        $items = Kelas::latest()->paginate(10);
        return view('admin.kelas.index', compact('items'));
    }

    public function create()
    {
       
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'angkatan' => 'required|in:X,XI,XII',
            'nama_kelas' => 'required',
            'singkatan' => 'required'
        ]);
        Kelas::create([
            'angkatan'  => $request->tingkatan,
            'nama_kelas' => $request->nama_kelas,
            'singkatan'  => $request->singkatan
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success','Kelas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'angkatan'   => 'required|in:X,XI,XII',
            'nama_kelas'  => 'required|max:50',
            'singkatan'   => 'required|unique:kelas,singkatan,'.$id
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'angkatan'  => $request->tingkatan,
            'nama_kelas' => $request->nama_kelas,
            'singkatan'  => $request->singkatan
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success','Kelas berhasil diupdate');
    }

    public function destroy($id)
    {
        Kelas::findOrFail($id)->delete();
        return redirect()->route('admin.kelas.index')
            ->with('success','Kelas berhasil dihapus');
    }
}
