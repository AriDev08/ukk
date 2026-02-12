@extends('layouts.admin')

@section('title', 'Data Jurusan')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Data Jurusan</h1>

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah Jurusan --}}
    <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-lg font-semibold mb-3">Tambah Jurusan</h2>

        <form action="{{ route('admin.jurusan.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nama Jurusan</label>
                <input type="text" name="nama_jurusan"
                    class="w-full border rounded px-3 py-2"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium">Singkatan</label>
                <input type="text" name="singkatan"
                    class="w-full border rounded px-3 py-2"
                    required>
            </div>

            <div class="flex items-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Jurusan --}}
    <div class="bg-white shadow rounded p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">No</th>
                    <th class="border p-2">Nama Jurusan</th>
                    <th class="border p-2">Singkatan</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border p-2">{{ $item->nama_jurusan }}</td>
                    <td class="border p-2">{{ $item->singkatan }}</td>
                    <td class="border p-2 text-center space-x-2">

                        {{-- Edit --}}
                        <form action="{{ route('admin.jurusan.update', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')

                            <input type="text" name="nama_jurusan"
                                value="{{ $item->nama_jurusan }}"
                                class="border rounded px-2 py-1 w-40">

                            <input type="text" name="singkatan"
                                value="{{ $item->singkatan }}"
                                class="border rounded px-2 py-1 w-20">

                            <button class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Update
                            </button>
                        </form>

                        {{-- Hapus --}}
                        <a href="{{ route('admin.jurusan.destroy', $item->id) }}"
                           onclick="return confirm('Yakin hapus jurusan ini?')"
                           class="bg-red-600 text-white px-3 py-1 rounded">
                            Hapus
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
