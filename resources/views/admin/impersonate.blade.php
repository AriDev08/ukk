@extends('layouts.app')

@section('title', 'Login sebagai Siswa')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Impersonate Siswa</h1>
        <p class="text-sm text-slate-500">
            Masuk ke sistem sebagai akun siswa untuk simulasi.
        </p>
    </div>
    <form method="GET" action="{{ route('admin.impersonate.page') }}" class="flex gap-2">
        <input type="text"
               name="nis"
               value="{{ request('nis') }}"
               placeholder="Cari NIS..."
               class="border rounded-lg px-3 py-2 w-64">
        <button class="bg-primary text-white px-4 rounded-lg">
            Cari
        </button>
    </form>
    

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($siswa as $item)
        <div class="bg-white rounded-2xl border shadow-sm p-5 hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-12 w-12 rounded-full bg-primary/20 flex items-center justify-center font-bold text-primary text-lg">
                    {{ strtoupper(substr($item->name,0,1)) }}
                </div>
                <div>
                    <p class="font-bold">{{ $item->name }}</p>
                    <p class="text-xs text-slate-400">{{ $item->email }}</p>
                </div>
            </div>

            <form action="{{ route('admin.impersonate.start', $item->id) }}" method="POST">
                @csrf
                <button class="w-full bg-primary hover:bg-secondary text-white py-2 rounded-xl text-sm font-semibold transition">
                    Login sebagai siswa ini
                </button>
            </form>
        </div>
        @endforeach
    </div>

</div>
@endsection
