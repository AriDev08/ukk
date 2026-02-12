@extends('layouts.app')

@section('title', 'Tinjau Aspirasi #' . $aspirasi->id)
@section('page_title', 'Detail Laporan')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div class="flex items-center gap-5">
            <a href="{{ route('admin.aspirasi.index') }}" 
               class="h-12 w-12 flex items-center justify-center bg-white border border-slate-200 rounded-2xl text-slate-400 hover:text-primary hover:border-primary transition-all shadow-sm group">
                <i class="bi bi-chevron-left group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <nav class="flex text-[9px] font-black uppercase tracking-[3px] text-slate-400 mb-1">
                    <span>Admin</span>
                    <span class="mx-2 text-slate-300">/</span>
                    <span>Aspirasi</span>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-primary">#ASP-{{ $aspirasi->id }}</span>
                </nav>
                <h3 class="text-2xl font-black text-slate-800 tracking-tighter">Lembar Tinjauan Laporan</h3>
            </div>
        </div>

        @php
            $statusBadge = [
                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                'in_progress' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                'done' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                'rejected' => 'bg-rose-50 text-rose-600 border-rose-100'
            ][$aspirasi->status] ?? 'bg-slate-50 text-slate-600';
        @endphp
        <div class="flex items-center gap-4 px-6 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm">
            <div class="flex flex-col">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Status Saat Ini</span>
                <span class="text-[11px] font-bold text-slate-700 uppercase">{{ $aspirasi->status }}</span>
            </div>
            <div class="h-8 w-[1px] bg-slate-100"></div>
            <span class="h-3 w-3 rounded-full {{ explode(' ', $statusBadge)[0] }} border-2 {{ explode(' ', $statusBadge)[2] }}"></span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8">
                    <i class="bi bi-quote text-6xl text-slate-50"></i>
                </div>

                <div class="relative">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-900 text-white text-[9px] font-black uppercase tracking-[2px] rounded-md mb-6">
                        <span class="h-1 w-1 bg-primary rounded-full animate-pulse"></span>
                        {{ $aspirasi->category->name ?? 'General' }}
                    </span>
                    <h2 class="text-3xl font-black text-slate-800 leading-tight mb-10 tracking-tight">{{ $aspirasi->title }}</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 p-8 bg-slate-50 rounded-[2rem] border border-slate-100 mb-10">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Identitas Pengirim</label>
                        <p class="text-sm font-bold text-slate-800">{{ $aspirasi->user->name }}</p>
                        <p class="text-[11px] font-medium text-slate-400 tracking-tight">ID: {{ $aspirasi->user_id }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Waktu Registrasi</label>
                        <p class="text-sm font-bold text-slate-800">{{ $aspirasi->created_at->translatedFormat('d F Y') }}</p>
                        <p class="text-[11px] font-medium text-slate-400">{{ $aspirasi->created_at->format('H:i') }} WIB</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Dokumen Bukti</label>
                        @if($aspirasi->attachment_path)
                            <a href="{{ asset('storage/'.$aspirasi->attachment_path) }}" target="_blank" class="flex items-center gap-2 text-primary font-black text-[11px] hover:underline decoration-2">
                                <i class="bi bi-file-earmark-text"></i> LIHAT LAMPIRAN
                            </a>
                        @else
                            <p class="text-[11px] font-black text-slate-300 italic">TIDAK TERSEDIA</p>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-[2px] block">Narasi Aspirasi</label>
                    <div class="text-slate-600 leading-relaxed font-medium text-[15px] p-6 bg-white border border-slate-100 rounded-2xl shadow-inner">
                        {{ $aspirasi->description }}
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] p-10 shadow-2xl shadow-slate-300">
                <div class="flex items-center gap-3 mb-8">
                    <div class="h-10 w-10 bg-primary/20 rounded-xl flex items-center justify-center text-primary">
                        <i class="bi bi-shield-check text-xl"></i>
                    </div>
                    <h5 class="text-lg font-black text-white tracking-tight">Panel Kendali Admin</h5>
                </div>
                
                <form method="POST" action="{{ route('admin.aspirasi.feedback', $aspirasi->id) }}" class="space-y-8">
                    @csrf
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Perbarui Status Laporan</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach(['pending', 'in_progress', 'done', 'rejected'] as $status)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="status" value="{{ $status }}" class="peer hidden" @checked($aspirasi->status == $status)>
                                    <div class="py-4 text-center rounded-2xl border-2 border-slate-800 text-[10px] font-black uppercase text-slate-500 peer-checked:border-primary peer-checked:text-white peer-checked:bg-primary/10 transition-all">
                                        {{ str_replace('_', ' ', $status) }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Catatan Feedback untuk Siswa</label>
                        <textarea name="note" rows="5" required
                                  class="w-full px-6 py-5 bg-slate-800 border-none rounded-[1.5rem] text-white font-medium placeholder:text-slate-600 focus:ring-4 focus:ring-primary/20 outline-none resize-none transition-all"
                                  placeholder="Berikan keterangan resmi mengenai tindakan yang diambil..."></textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="w-full md:w-auto px-12 py-5 bg-primary text-white font-black rounded-2xl hover:bg-indigo-400 transition-all shadow-xl shadow-indigo-900/40 uppercase text-xs tracking-widest">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm sticky top-24">
                <div class="flex items-center justify-between mb-10">
                    <h6 class="text-[11px] font-black text-slate-800 uppercase tracking-[2px]">Log Histori</h6>
                    <i class="bi bi-arrow-repeat text-slate-300"></i>
                </div>

                <div class="space-y-10 relative">
                    <div class="absolute left-[19px] top-2 bottom-2 w-[2px] bg-slate-100"></div>

                    @forelse($aspirasi->histories->sortByDesc('created_at') as $h)
                        <div class="relative pl-12 group">
                            <div class="absolute left-0 top-0 h-10 w-10 bg-white border-2 border-slate-100 rounded-xl flex items-center justify-center z-10 group-first:border-primary transition-colors">
                                <div class="h-2 w-2 bg-slate-200 rounded-full group-first:bg-primary"></div>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black text-primary uppercase tracking-tighter">{{ strtoupper($h->to_status) }}</span>
                                    <span class="text-[9px] font-bold text-slate-300 uppercase">{{ $h->created_at->translatedFormat('d M H:i') }}</span>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-[11px] font-bold text-slate-600 leading-relaxed">{{ $h->note }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center space-y-3">
                            <i class="bi bi-inbox text-4xl text-slate-100"></i>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Belum Ada Histori</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Menghaluskan scrollbar sidebar jika konten timeline sangat panjang */
    .sticky::-webkit-scrollbar {
        width: 4px;
    }
    .sticky::-webkit-scrollbar-thumb {
        background: #f1f5f9;
        border-radius: 10px;
    }
</style>
@endsection