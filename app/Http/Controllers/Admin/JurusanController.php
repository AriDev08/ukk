<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{

    public function index()
    {
        $items = Jurusan::latest()->paginate(10);
        return view('admin.jurusan.index', compact('items'));
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|unique:jurusan,nama_jurusan',
            'singkatan' => 'required|unique:jurusan,singkatan',
        ]);

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
            'singkatan' => $request->singkatan,
        ]);

        return redirect()->back()->with('success','Jurusan berhasil ditambahkan');
    }

    // Update jurusan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required|unique:jurusan,nama_jurusan,'.$id,
            'singkatan' => 'required|unique:jurusan,singkatan,'.$id,
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
            'singkatan' => $request->singkatan,
        ]);

        return redirect()->back()->with('success','Jurusan berhasil diupdate');
    }

    // Hapus jurusan
    public function destroy($id)
    {
        Jurusan::findOrFail($id)->delete();
        return redirect()->back()->with('success','Jurusan berhasil dihapus');
    }
   
}
