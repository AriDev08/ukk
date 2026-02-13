@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('page_title', 'Form Siswa')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="flex items-center gap-5 mb-10">
        <div class="h-16 w-16 bg-gradient-to-tr from-emerald-500 to-primary rounded-2xl flex items-center justify-center text-white shadow-lg rotate-3">
            <i class="bi bi-person-plus-fill text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Data Siswa</h3>
            <p class="text-sm text-slate-500 font-medium">Input data siswa baru</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-6 bg-rose-50 border-l-8 border-rose-500 rounded-3xl">
            <ul class="text-xs text-rose-600 font-medium space-y-1">
                @foreach ($errors->all() as $err)
                    <li>• {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-8">
        @csrf

        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">
                NIS
            </label>
            <input name="nis"
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                       focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                       transition-all outline-none font-bold text-slate-700"
                placeholder="20260001" required>
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">
                Nama Lengkap
            </label>
            <input name="nama"
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                       focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                       transition-all outline-none font-bold text-slate-700"
                placeholder="I Made Arya Santika" required>
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">
                Kelas
            </label>
            <select name="kelas_id"
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                       focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                       transition-all outline-none font-bold text-slate-700"
                required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">
                        {{ $k->singkatan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select name="jurusan_id" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach($jurusan as $j)
                    <option value="{{ $j->id }}">
                        {{ $j->nama_jurusan }}
                    </option>
                @endforeach
            </select>
        </div>
        

        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">
                Email
            </label>
            <input name="email"
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                       focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                       transition-all outline-none font-bold text-slate-700"
                placeholder="arya@gmail.com">
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">
                Password Login
            </label>
            <input type="password" name="password"
                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-[1.5rem]
                       focus:bg-white focus:border-primary focus:ring-8 focus:ring-primary/5
                       transition-all outline-none font-bold text-slate-700"
                placeholder="Minimal 6 karakter" required>
        </div>

        <div class="flex items-center justify-between pt-8 border-t border-slate-100">
            <a href="{{ route('admin.siswa.index') }}"
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
