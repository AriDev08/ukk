<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Jurusan;
class KelasController extends Controller
{
    public function index()
    {
        $items = Kelas::with('jurusan')
                      ->latest()
                      ->paginate(10);
    
        return view('admin.kelas.index', compact('items'));
    }
    
    public function create()
    {
        $jurusan = Jurusan::all();
        return view('admin.kelas.create', compact('jurusan'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'angkatan'     => 'required|in:X,XI,XII',
            'nama_kelas'   => 'required',
            'singkatan'    => 'required',
            'jurusan_id'   => 'required|exists:jurusan,id'
        ]);
        
        Kelas::create([
            'angkatan'     => $request->angkatan,
            'nama_kelas'   => $request->nama_kelas,
            'singkatan'    => $request->singkatan,
            'jurusan_id'   => $request->jurusan_id,
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
