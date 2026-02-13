@extends('layouts.app')

@section('title', 'Data Kelas')
@section('page_title', 'Manajemen Kelas')

@section('content')
<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Data Kelas</h3>
            <p class="text-sm text-slate-500">Kelola kelas berdasarkan angkatan dan jurusan.</p>
        </div>
        <a href="{{ route('admin.kelas.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-secondary text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-100 group">
            <i class="bi bi-plus-lg group-hover:rotate-90 transition-transform"></i>
            <span>Tambah Kelas</span>
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center p-4 mb-4 text-emerald-800 border-t-4 border-emerald-300 bg-emerald-50 rounded-2xl shadow-sm">
            <i class="bi bi-check-circle-fill text-xl"></i>
            <div class="ml-3 text-sm font-bold">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="overflow-hidden border border-slate-100 rounded-[2rem] bg-slate-50/50 p-2">
        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-y-3 px-2">
                <thead>
                    <tr class="text-left text-slate-400 uppercase text-[10px] tracking-[2px] font-bold">
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Jurusan</th>
                        <th class="px-6 py-4">Singkatan</th>
                        <th class="px-6 py-4 text-center">Angkatan</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $row)
                    <tr class="bg-white hover:bg-slate-50 transition-all duration-300 shadow-sm hover:shadow-md rounded-2xl group">
                        
                        <td class="px-6 py-5 rounded-l-2xl border-y border-l border-transparent group-hover:border-slate-100">
                            <span class="text-sm font-bold text-slate-800 uppercase">
                                {{ $row->nama_kelas }}
                            </span>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100">
                            <span class="text-xs font-bold text-slate-600">
                                {{ $row->nama_jurusan ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                                {{ $row->singkatan }}
                            </span>
                        </td>

                        <td class="px-6 py-5 border-y border-transparent group-hover:border-slate-100 text-center">
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-xl text-[10px] font-black border 
                                bg-indigo-100 text-indigo-600 border-indigo-200 min-w-[80px] shadow-sm uppercase">
                                {{ $row->angkatan }}
                            </span>
                        </td>

                        <td class="px-6 py-5 rounded-r-2xl border-y border-r border-transparent group-hover:border-slate-100 text-right space-x-2">
                            
                            <a href="{{ route('admin.kelas.edit', $row->id) }}" 
                               class="inline-flex items-center px-3 py-2 bg-amber-100 text-amber-700 rounded-xl text-xs font-bold hover:bg-amber-500 hover:text-white transition-all">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('admin.kelas.destroy', $row->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex items-center px-3 py-2 bg-rose-100 text-rose-700 rounded-xl text-xs font-bold hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="h-20 w-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="bi bi-inbox text-slate-300 text-3xl"></i>
                                </div>
                                <h4 class="text-slate-800 font-bold">Belum Ada Data Kelas</h4>
                                <p class="text-sm text-slate-400">Silakan tambahkan kelas terlebih dahulu.</p>
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
            Showing <span class="text-primary">{{ $items->firstItem() ?? 0 }}</span> - 
            <span class="text-primary">{{ $items->lastItem() ?? 0 }}</span> 
            of {{ $items->total() }} entries
        </p>
        <div class="custom-pagination">
            {{ $items->links() }}
        </div>
    </div>
</div>

<style>
.custom-pagination nav svg { width: 20px; display: inline; }
.custom-pagination nav div:first-child { display: none; }
.custom-pagination nav div:last-child span, 
.custom-pagination nav div:last-child a { 
    border-radius: 12px !important; 
    margin: 0 2px;
    font-weight: 700;
    font-size: 12px;
}
</style>
@endsection
