<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\AspirasiHistory;
use Illuminate\Http\Request;

class AspirasiAdminController extends Controller
{
    // list semua aspirasi
    public function index()
    {
        $items = Aspirasi::with(['user','category'])
            ->latest()
            ->paginate(10);

        return view('admin.aspirasi.index', compact('items'));
    }

    // detail aspirasi
    public function show($id)
    {
        $aspirasi = Aspirasi::with(['user','category','histories'])
            ->findOrFail($id);

        return view('admin.aspirasi.show', compact('aspirasi'));
    }
    public function feedback(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,done,rejected',
            'note' => 'required'
        ]);
    
        $aspirasi = Aspirasi::findOrFail($id);
        $old = $aspirasi->status;
    
        $aspirasi->update([
            'status' => $request->status
        ]);
    
        AspirasiHistory::create([
            'aspirasi_id' => $aspirasi->id,
            'from_status' => $old,
            'to_status' => $request->status,
            'changed_by' => auth()->id(), 
            'note' => $request->note
        ]);
    
        return redirect()->back()->with('success','Umpan balik berhasil disimpan');
    }
    
    
}
