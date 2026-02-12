@extends('layouts.app')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Pusat Kendali Admin')

@section('content')
<div class="space-y-10">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Manajemen Kategori</h3>
            <p class="text-sm text-slate-500 font-medium">
                Total <span class="text-primary font-bold">{{ $categories->total() }} kategori</span> tersedia.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 px-5 py-3 bg-darkNavy text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 text-sm">
            <i class="bi bi-plus-lg"></i>
            Tambah Kategori
        </a>
    </div>

    {{-- CARD STAT --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="p-6 rounded-[2rem] bg-gradient-to-br from-indigo-500 to-primary text-white shadow-xl">
            <div class="flex justify-between mb-4">
                <div class="h-12 w-12 bg-white/20 rounded-2xl flex items-center justify-center">
                    <i class="bi bi-tags-fill text-xl"></i>
                </div>
                <span class="text-[10px] font-black bg-white/20 px-3 py-1 rounded-full uppercase">
                    Total
                </span>
            </div>
            <h4 class="text-3xl font-black">{{ $categories->total() }}</h4>
            <p class="text-xs uppercase font-bold text-indigo-100">Kategori</p>
        </div>

        <div class="p-6 rounded-[2rem] bg-white border border-slate-100 shadow-xl">
            <div class="flex justify-between mb-4">
                <div class="h-12 w-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                    <i class="bi bi-check-circle-fill text-xl"></i>
                </div>
                <span class="text-[10px] font-black bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full uppercase">
                    Aktif
                </span>
            </div>
            <h4 class="text-3xl font-black text-slate-800">{{ $categories->count() }}</h4>
            <p class="text-xs uppercase font-bold text-slate-400">Data Ditampilkan</p>
        </div>

        <div class="p-6 rounded-[2rem] bg-white border border-slate-100 shadow-xl">
            <div class="flex justify-between mb-4">
                <div class="h-12 w-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500">
                    <i class="bi bi-clock-history text-xl"></i>
                </div>
                <span class="text-[10px] font-black bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full uppercase">
                    Halaman
                </span>
            </div>
            <h4 class="text-3xl font-black text-slate-800">{{ $categories->currentPage() }}</h4>
            <p class="text-xs uppercase font-bold text-slate-400">Page Aktif</p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-100 rounded-[2.5rem] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase">No</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase">Nama Kategori</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($categories as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors group">

                        <td class="px-8 py-6 font-bold text-slate-600">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-8 py-6">
                            <span class="text-sm font-bold text-slate-700 group-hover:text-primary">
                                {{ $item->name }}
                            </span>
                        </td>

                        <td class="px-8 py-6 text-right space-x-2">

                            <a href="{{ route('admin.categories.edit', $item->id) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 rounded-xl text-xs font-black hover:bg-amber-100">
                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $item->id) }}"
                                  method="POST"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus kategori ini?')"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-black hover:bg-red-100">
                                    Hapus
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center text-slate-400 font-bold">
                            Belum ada kategori.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="flex items-center justify-between px-2">
        <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
            Halaman {{ $categories->currentPage() }} dari {{ $categories->lastPage() }}
        </div>
        <div>
            {{ $categories->links() }}
        </div>
    </div>

</div>
@endsection
