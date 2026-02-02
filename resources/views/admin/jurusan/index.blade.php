@extends('layouts.app')

@section('title','Data Jurusan')

@section('content')
<div class="container">
    <h4 class="mb-3">Data Jurusan</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- FORM TAMBAH JURUSAN -->
    <form action="{{ route('admin.jurusan.store') }}" method="POST" class="row g-2 mb-4">
        @csrf
        <div class="col-md-5">
            <input type="text" name="nama_jurusan" class="form-control" placeholder="Nama Jurusan" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="singkatan" class="form-control" placeholder="Singkatan (RPL)" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Tambah</button>
        </div>
    </form>

    <!-- TABEL JURUSAN -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jurusan</th>
                <th>Singkatan</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $row)
            <tr>
                <form action="{{ route('admin.jurusan.update',$row->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <input name="nama_jurusan" value="{{ $row->nama_jurusan }}" class="form-control" required>
                    </td>
                    <td>
                        <input name="singkatan" value="{{ $row->singkatan }}" class="form-control" required>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-success mb-1">Update</button>
                        <a href="{{ route('admin.jurusan.destroy',$row->id) }}"
                           onclick="return confirm('Hapus?')"
                           class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
