@extends('layouts.app')

@section('title', 'Manajemen Aspirasi')
@section('page_title', 'Pusat Kendali Admin')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Manajemen Aspirasi</h3>
            <p class="text-sm text-slate-500 font-medium">Terdapat <span class="text-primary font-bold">{{ $items->total() }} laporan</span> yang memerlukan perhatian Anda.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 px-5 py-3 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl hover:bg-slate-50 transition-all shadow-sm text-sm">
                <i class="bi bi-download"></i> Ekspor CSV
            </button>
            <button class="flex items-center gap-2 px-5 py-3 bg-darkNavy text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 text-sm">
                <i class="bi bi-printer"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group p-6 rounded-[2rem] bg-gradient-to-br from-indigo-500 to-primary text-white shadow-xl shadow-indigo-100 hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <i class="bi bi-envelope-paper-fill text-xl"></i>
                </div>
                <span class="text-[10px] font-black bg-white/20 px-3 py-1 rounded-full uppercase tracking-widest">Total</span>
            </div>
            <h4 class="text-3xl font-black mb-1">{{ $items->total() }}</h4>
            <p class="text-indigo-100 text-xs font-bold uppercase tracking-tighter">Aspirasi Masuk</p>
        </div>

        <div class="group p-6 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                    <i class="bi bi-clock-history text-xl"></i>
                </div>
                <span class="text-[10px] font-black bg-amber-100 text-amber-600 px-3 py-1 rounded-full uppercase tracking-widest">Pending</span>
            </div>
            <h4 class="text-3xl font-black text-slate-800 mb-1">{{ $items->where('status', 'pending')->count() }}</h4>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-tighter">Perlu Tindakan</p>
        </div>

        <div class="group p-6 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/50 hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                    <i class="bi bi-check-all text-2xl"></i>
                </div>
                <span class="text-[10px] font-black bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full uppercase tracking-widest">Selesai</span>
            </div>
            <h4 class="text-3xl font-black text-slate-800 mb-1">{{ $items->where('status', 'done')->count() }}</h4>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-tighter">Telah Diatasi</p>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengirim & Waktu</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Subjek Aspirasi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($items as $row)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border-2 border-white shadow-sm ring-1 ring-slate-100">
                                    {{ strtoupper(substr($row->user->name, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800">{{ $row->user->name }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $row->created_at->translatedFormat('d M Y • H:i') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700 group-hover:text-primary transition-colors">{{ $row->title }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">Ticket ID: <span class="text-slate-500">#ASP-{{ $row->id }}</span></span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center">
                                @php
                                    $statusMap = [
                                        'pending' => 'bg-amber-100 text-amber-600 border-amber-200',
                                        'process' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                                        'done'    => 'bg-emerald-100 text-emerald-600 border-emerald-200'
                                    ];
                                    $style = $statusMap[$row->status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                                @endphp
                                <span class="px-4 py-1.5 rounded-xl border {{ $style }} text-[10px] font-black uppercase tracking-tighter shadow-sm">
                                    {{ $row->status }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.aspirasi.show', $row->id) }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-black text-slate-700 hover:bg-darkNavy hover:text-white hover:border-darkNavy transition-all shadow-sm">
                                Tinjau
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4">
                                    <i class="bi bi-folder-x text-4xl"></i>
                                </div>
                                <p class="text-slate-400 font-bold italic">Belum ada aspirasi yang masuk hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex items-center justify-between px-2">
        <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
            Halaman {{ $items->currentPage() }} dari {{ $items->lastPage() }}
        </div>
        <div class="custom-pagination">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection