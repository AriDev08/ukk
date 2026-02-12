<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Category;
use App\Models\AspirasiHistory;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index()
{
    return view('dashboard');
}
    public function create()
    {
        $categories = Category::all();
        return view('aspirasi.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
            'location'    => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')
                           ->store('attachments', 'public');
        }

        $aspirasi = Aspirasi::create([
            'user_id'         => auth()->id(), // ✅ FIX
            'category_id'     => $request->category_id,
            'title'           => $request->title,
            'location'        => $request->location, // ✅ LOKASI
            'description'     => $request->description,
            'attachment_path' => $path,
            'status'          => 'pending',
        ]);

        AspirasiHistory::create([
            'aspirasi_id' => $aspirasi->id,
            'from_status' => null,
            'to_status'   => 'pending',
            'changed_by'  => auth()->id(), // ✅ FIX
            'note'        => 'Aspirasi dibuat oleh siswa',
        ]);

        return redirect()
            ->route('aspirasi.history')
            ->with('success', 'Aspirasi berhasil dikirim');
    }

    public function history()
    {
        $items = Aspirasi::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('aspirasi.history', compact('items'));
    }
}
