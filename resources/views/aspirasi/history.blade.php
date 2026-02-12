@extends('layouts.app')

@section('title', 'Histori Aspirasi')
@section('page_title', 'Histori Pengajuan')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Lacak Aspirasi Anda</h3>
            <p class="text-sm text-slate-500">Pantau status dan tanggapan admin secara real-time.</p>
        </div>
        <a href="{{ route('aspirasi.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-secondary text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-100 group">
            <i class="bi bi-plus-lg group-hover:rotate-90 transition-transform"></i>
            <span>Buat Aspirasi Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center p-4 mb-4 text-emerald-800 border-t-4 border-emerald-300 bg-emerald-50 rounded-2xl shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill text-xl"></i>
            <div class="ml-3 text-sm font-bold">
                {{ session('success') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 bg-emerald-50 text-emerald-500 rounded-lg p-1.5 hover:bg-emerald-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-1" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <div class="overflow-hidden border border-slate-100 rounded-[2rem] bg-slate-50/50 p-2">
        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-y-3 px-2">
                <thead>
                    <tr class="text-left text-slate-400 uppercase text-[10px] tracking-[2px] font-bold">
                        <th class="px-6 py-4">Info Dasar</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Feedback Terakhir</th>
                        <th class="px-6 py-4 text-right">Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $row)
                    <tr class="bg-white hover:bg-slate-50 transition-all duration-300 shadow-sm hover:shadow-md rounded-2xl group">
                        <td class="px-6 py-5 rounded-l-2xl border-y border-l border-transparent group-hover:border-slate-100">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-400 mb-1">{{ $row->created_at->translatedFormat('d M Y') }}</span>
                                <span class="text-sm font-bold text-slate-800 line-clamp-1 uppercase tracking-tight">{{ $row->title }}</span>
                                <span class="text-[11px] text-slate-400 italic line-clamp-1 mt-0.5">{{ Str::limit($row->description, 40) }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                                {{ $row->category->name }}
                            </span>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-600 border-amber-200',
                                    'process' => 'bg-indigo-100 text-indigo-600 border-indigo-200',
                                    'done'    => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                    'rejected'=> 'bg-rose-100 text-rose-600 border-rose-200'
                                ];
                                $currentClass = $statusClasses[$row->status] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-xl text-[10px] font-black border {{ $currentClass }} min-w-[100px] shadow-sm uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-current mr-2 animate-pulse"></span>
                                {{ $row->status }}
                            </span>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100">
                            @php $lastFeedback = $row->histories->last(); @endphp
                            @if($lastFeedback)
                                <div class="flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                        <i class="bi bi-chat-left-text text-xs"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[11px] font-bold text-slate-700">{{ $lastFeedback->admin->name ?? 'Admin' }}</span>
                                        <span class="text-[10px] text-slate-400 line-clamp-1">{{ $lastFeedback->note }}</span>
                                    </div>
                                </div>
                            @else
                                <span class="text-[11px] font-medium text-slate-300 italic">Menunggu respon...</span>
                            @endif
                        </td>

                        <td class="px-6 py-5 rounded-r-2xl border-y border-r border-transparent group-hover:border-slate-100 text-right">
                            @if($row->attachment_path)
                                <a href="{{ asset('storage/'.$row->attachment_path) }}" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                    File
                                </a>
                            @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase">No File</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="bi bi-inbox text-slate-300 text-3xl"></i>
                                </div>
                                <h4 class="text-slate-800 font-bold">Belum Ada Aspirasi</h4>
                                <p class="text-sm text-slate-400">Suara Anda sangat berarti bagi kami. Mulailah menulis aspirasi.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6 px-4">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
            Showing <span class="text-primary">{{ $items->firstItem() ?? 0 }}</span> - <span class="text-primary">{{ $items->lastItem() ?? 0 }}</span> of {{ $items->total() }} entries
        </p>
        <div class="custom-pagination">
            {{ $items->links() }}
        </div>
    </div>
</div>

<style>
  
    .custom-pagination nav svg { width: 20px; display: inline; }
    .custom-pagination nav div:first-child { display: none; } /* Hide mobile nav from default laravel */
    .custom-pagination nav div:last-child span, 
    .custom-pagination nav div:last-child a { 
        border-radius: 12px !important; 
        margin: 0 2px;
        font-weight: 700;
        font-size: 12px;
    }
</style>
@endsection