@extends('layouts.app')
@section('title','Data Siswa')

@section('content')
<div class="container">
    <h4 class="mb-3">Data Siswa</h4>

    <form action="{{ route('admin.siswa.store') }}" method="POST" class="row g-2 mb-4">
        @csrf
        <div class="col-md-2">
            <input name="nis" class="form-control" placeholder="NIS" required>
        </div>
        <div class="col-md-3">
            <input name="nama" class="form-control" placeholder="Nama" required>
        </div>
        <div class="col-md-3">
            <select name="kelas_id" class="form-select" required>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">
                        {{ $k->singkatan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input name="email" class="form-control" placeholder="Email (opsional)">
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary">+</button>
        </div>
    </form>

    <table class="table table-bordered">
        <tr>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th width="120">Aksi</th>
        </tr>
        @foreach($items as $row)
        <tr>
            <td>{{ $row->nis }}</td>
            <td>{{ $row->nama }}</td>
            <td>{{ $row->kelas->singkatan }}</td>
            <td>{{ $row->kelas->jurusan->kode }}</td>
            <td>
                <a href="{{ route('admin.siswa.destroy',$row->id) }}"
                   onclick="return confirm('Hapus?')"
                   class="btn btn-sm btn-danger">Del</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
