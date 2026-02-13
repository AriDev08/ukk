@extends('layouts.app')

@section('title', 'Tambah Kelas')
@section('page_title', 'Form Kelas')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-5 mb-10">
        <div class="h-16 w-16 bg-gradient-to-tr from-indigo-500 to-primary rounded-2xl flex items-center justify-center text-white shadow-lg rotate-3">
            <i class="bi bi-building text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Data Kelas</h3>
            <p class="text-sm text-slate-500 font-medium">Struktur kelas utama sekolah</p>
        </div>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-8 p-6 bg-rose-50 border-l-8 border-rose-500 rounded-3xl">
            <ul class="text-xs text-rose-600 font-medium space-y-1">
                @foreach ($errors->all() as $err)
                    <li>• {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-8">
        @csrf

       
        <select name="angkatan" class="form-control" required>
            <option value="">-- Pilih Angkatan --</option>
            <option value="X">X</option>
            <option value="XI">XI</option>
            <option value="XII">XII</option>
        </select>
        

        {{-- Nama Kelas --}}
        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">
                Nama Kelas
            </label>
            <input name="nama_kelas"
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                       focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                       transition-all outline-none font-bold text-slate-700"
                placeholder="X RPL 1" required>
        </div>

        {{-- Singkatan --}}
        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">
                Singkatan
            </label>
            <input name="singkatan"
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                       focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                       transition-all outline-none font-bold text-slate-700"
                placeholder="XRPL1">
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-8 border-t border-slate-100">
            <a href="{{ route('admin.kelas.index') }}"
               class="text-[11px] font-black text-slate-400 hover:text-rose-500 uppercase tracking-[2px]">
                <i class="bi bi-arrow-left-circle-fill"></i> Kembali
            </a>

            <button type="submit"
                class="px-12 py-5 bg-slate-900 text-white font-black rounded-[1.5rem]
                       shadow-xl hover:bg-primary hover:-translate-y-1
                       transition-all active:scale-95 flex items-center gap-3">
                <span>SIMPAN</span>
                <i class="bi bi-check-circle-fill"></i>
            </button>
        </div>
    </form>
</div>
@endsection
