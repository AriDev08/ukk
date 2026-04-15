@extends('layouts.app')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Pusat Kendali Admin')

@section('content')
<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">Manajemen Kategori</h3>
            <p class="text-sm text-slate-500">
                Total 
                <span class="text-indigo-600 font-semibold">
                    {{ $categories->total() }}
                </span> kategori tersedia.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 px-5 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-md text-sm">
            <i class="bi bi-plus-lg"></i>
            Tambah Kategori
        </a>
    </div>

    {{-- CARD STAT --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="p-6 rounded-2xl bg-indigo-600 text-white shadow-md">
            <div class="flex justify-between items-center mb-4">
                <i class="bi bi-tags-fill text-2xl opacity-80"></i>
                <span class="text-xs uppercase font-semibold bg-white/20 px-3 py-1 rounded-full">
                    Total
                </span>
            </div>
            <h4 class="text-3xl font-bold">{{ $categories->total() }}</h4>
            <p class="text-sm opacity-80">Kategori</p>
        </div>

        <div class="p-6 rounded-2xl bg-white border shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <i class="bi bi-check-circle-fill text-2xl text-emerald-500"></i>
                <span class="text-xs uppercase font-semibold bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full">
                    Aktif
                </span>
            </div>
            <h4 class="text-3xl font-bold text-slate-800">
                {{ $categories->count() }}
            </h4>
            <p class="text-sm text-slate-400">Data Ditampilkan</p>
        </div>

        <div class="p-6 rounded-2xl bg-white border shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <i class="bi bi-clock-history text-2xl text-indigo-500"></i>
                <span class="text-xs uppercase font-semibold bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full">
                    Halaman
                </span>
            </div>
            <h4 class="text-3xl font-bold text-slate-800">
                {{ $categories->currentPage() }}
            </h4>
            <p class="text-sm text-slate-400">Page Aktif</p>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">
                            No
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">
                            Nama Kategori
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-right">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($categories as $item)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4 text-sm font-medium text-slate-600">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 text-sm font-semibold text-slate-700">
                            {{ $item->name }}
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">

                            <a href="{{ route('admin.categories.edit', $item->id) }}"
                               class="px-4 py-2 text-xs font-semibold bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition">
                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $item->id) }}"
                                  method="POST"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus kategori ini?')"
                                    class="px-4 py-2 text-xs font-semibold bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-16 text-center text-slate-400 font-medium">
                            Belum ada kategori.
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

    <div class="flex items-center justify-between">
        <div class="text-xs text-slate-500">
            Halaman {{ $categories->currentPage() }} dari {{ $categories->lastPage() }}
        </div>
        <div>
            {{ $categories->links() }}
        </div>
    </div>

</div>
@endsection
