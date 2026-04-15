@extends('layouts.app')

@section('title', 'Tinjau Aspirasi #' . $aspirasi->id)
@section('page_title', 'Detail Laporan')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
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
                <h3 class="text-2xl font-black text-slate-800 tracking-tighter">
                    Lembar Tinjauan Laporan
                </h3>
            </div>
        </div>

        @php
            $statusBadge = [
                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                'in_progress' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                'done' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                'rejected' => 'bg-rose-50 text-rose-600 border-rose-100'
            ][$aspirasi->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
        @endphp

        <div class="flex items-center gap-4 px-6 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm">
            <div class="flex flex-col">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                    Status Saat Ini
                </span>
                <span class="text-[11px] font-bold text-slate-700 uppercase">
                    {{ str_replace('_',' ',$aspirasi->status) }}
                </span>
            </div>
            <div class="h-8 w-[1px] bg-slate-100"></div>
            <span class="h-3 w-3 rounded-full {{ explode(' ', $statusBadge)[0] }} border-2 {{ explode(' ', $statusBadge)[2] }}"></span>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- LEFT CONTENT --}}
        <div class="lg:col-span-8 space-y-8">

            {{-- DETAIL CARD --}}
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8">
                    <i class="bi bi-quote text-6xl text-slate-50"></i>
                </div>

                <div class="relative">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-slate-900 text-white text-[9px] font-black uppercase tracking-[2px] rounded-md mb-6">
                        <span class="h-1 w-1 bg-primary rounded-full animate-pulse"></span>
                        {{ $aspirasi->category->name ?? 'General' }}
                    </span>

                    <h2 class="text-3xl font-black text-slate-800 leading-tight mb-10 tracking-tight">
                        {{ $aspirasi->title }}
                    </h2>
                </div>

                {{-- GRID INFO --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 p-8 bg-slate-50 rounded-[2rem] border border-slate-100 mb-10">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Identitas Pengirim</label>
                        <p class="text-sm font-bold text-slate-800">{{ $aspirasi->user->name }}</p>
                        <p class="text-[11px] font-medium text-slate-400">ID: {{ $aspirasi->user_id }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Waktu Registrasi</label>
                        <p class="text-sm font-bold text-slate-800">{{ $aspirasi->created_at->translatedFormat('d F Y') }}</p>
                        <p class="text-[11px] font-medium text-slate-400">{{ $aspirasi->created_at->format('H:i') }} WIB</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Dokumen Bukti</label>
                        @if($aspirasi->attachment_path)
                        <div class="mt-3">
                            <img src="{{ asset('storage/'.$aspirasi->attachment_path) }}" 
                                 alt="Lampiran"
                                 class="rounded-xl border border-slate-200 shadow-sm max-h-64 object-cover cursor-pointer hover:scale-105 transition"
                                 onclick="window.open(this.src, '_blank')">
                        </div>
                    @else
                            <p class="text-[11px] text-slate-400 italic">Tidak ada lampiran</p>
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

            {{-- ADMIN PANEL --}}
            <div class="bg-slate-900 rounded-[2.5rem] p-10 shadow-2xl shadow-slate-300">
                <h5 class="text-lg font-black text-white mb-8">Panel Kendali Admin</h5>

                <form method="POST" action="{{ route('admin.aspirasi.feedback', $aspirasi->id) }}" class="space-y-8">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Perbarui Status</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                            {{-- Gunakan peer-checked untuk memberikan efek visual saat dipilih --}}
                            @foreach(['pending' => 'Pending', 'in_progress' => 'Proses', 'done' => 'Selesai', 'rejected' => 'Tolak'] as $val => $label)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="status" value="{{ $val }}" class="hidden peer" @checked($aspirasi->status == $val)>
                                    <div class="py-4 text-center rounded-2xl border-2 border-slate-800 text-[10px] font-black uppercase text-slate-500 
                                                peer-checked:border-primary peer-checked:text-white peer-checked:bg-primary/20 
                                                hover:border-slate-600 transition-all duration-300">
                                        {{ $label }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Catatan Feedback</label>
                        {{-- NOTE: Tag textarea harus rapat tanpa spasi agar required bekerja dengan benar --}}
                        <textarea name="note" rows="5" required placeholder="Tulis instruksi atau alasan perubahan status..."
                                  class="w-full mt-3 px-6 py-5 bg-slate-800 rounded-[1.5rem] text-white resize-none border-2 border-transparent focus:border-primary focus:ring-0 transition-all">{{ old('note') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-12 py-4 bg-primary text-white font-black rounded-2xl uppercase text-xs hover:shadow-lg hover:shadow-primary/30 active:scale-95 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT SIDE TIMELINE --}}
        <div class="lg:col-span-4">
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm sticky top-24">
                <h6 class="text-[11px] font-black text-slate-800 uppercase tracking-[2px] mb-8">Log Histori</h6>
                @forelse($aspirasi->histories->sortByDesc('created_at') as $h)
                    <div class="mb-6 border-l-2 border-slate-100 pl-4 relative">
                        <div class="absolute -left-[9px] top-0 h-4 w-4 bg-white border-2 border-primary rounded-full"></div>
                        <span class="text-[9px] font-black text-primary uppercase">
                            {{ str_replace('_',' ',$h->to_status) }}
                        </span>
                        <p class="text-[11px] text-slate-400">
                            {{ $h->created_at->translatedFormat('d M H:i') }}
                        </p>
                        <div class="mt-2 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-[11px] font-bold text-slate-600 italic">"{{ $h->note }}"</p>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <i class="bi bi-clock-history text-slate-200 text-3xl block mb-2"></i>
                        <p class="text-slate-400 text-xs font-bold uppercase italic">Belum Ada Histori</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection