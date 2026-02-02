<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Category;
use App\Models\AspirasiHistory;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    // tampilkan form
    public function create()
    {
        $categories = Category::all();
        return view('aspirasi.create', compact('categories'));
    }

    // simpan aspirasi
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:200',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'attachment' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        $aspirasi = Aspirasi::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'attachment_path' => $path,
            'status' => 'pending'
        ]);

        // simpan history awal
        AspirasiHistory::create([
            'aspirasi_id' => $aspirasi->id,
            'from_status' => null,
            'to_status' => 'pending',
            'changed_by' => auth()->id(),
            'note' => 'Aspirasi dibuat oleh siswa'
        ]);

        return redirect()->route('aspirasi.history')
            ->with('success', 'Aspirasi berhasil dikirim');
    }

    // histori aspirasi siswa
    public function history()
    {
        $items = Aspirasi::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('aspirasi.history', compact('items'));
    }
}
