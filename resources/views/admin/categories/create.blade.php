@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page_title', 'Pusat Kendali Admin')

@section('content')
<div class="space-y-10 max-w-4xl mx-auto">

    {{-- Header --}}
    <div>
        <h3 class="text-2xl font-black text-slate-800 tracking-tight">
            Tambah Kategori
        </h3>
        <p class="text-sm text-slate-500 font-medium">
            Tambahkan kategori baru untuk pengelompokan data.
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-slate-100 rounded-[2.5rem] p-10 shadow-sm">

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Input --}}
            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3">
                    Nama Kategori
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Infrastruktur"
                       class="w-full px-6 py-4 rounded-2xl border border-slate-200 text-sm font-semibold
                              focus:ring-2 focus:ring-primary focus:border-primary outline-none
                              transition-all"
                       required>

                @error('name')
                    <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action --}}
            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-600
                          font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition">
                    Kembali
                </a>

                <button type="submit"
                        class="px-8 py-3 rounded-2xl bg-darkNavy text-white
                               font-black text-xs uppercase tracking-widest
                               hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                    Simpan Kategori
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
