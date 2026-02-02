@extends('layouts.app')
@section('title','Data Kelas')

@section('content')
<div class="container">
    <h4 class="mb-3">Data Kelas</h4>

    <form action="{{ route('admin.kelas.store') }}" method="POST" class="row g-2 mb-4">
        @csrf
        <div class="col-md-2">
            <select name="tingkat" class="form-select" required>
                <option>X</option>
                <option>XI</option>
                <option>XII</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="jurusan_id" class="form-select" required>
                @foreach($jurusan as $j)
                    <option value="{{ $j->id }}">{{ $j->kode }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <input name="rombel" class="form-control" placeholder="1 / 2 / 3">
        </div>

        <div class="col-md-2">
            <input name="singkatan" class="form-control" placeholder="X-RPL-1">
        </div>

        <div class="col-md-2">
            <input name="angkatan" class="form-control" placeholder="2024">
        </div>

        <div class="col-md-1">
            <button class="btn btn-primary">+</button>
        </div>
    </form>

    <table class="table table-bordered">
        <tr>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Singkatan</th>
            <th>Angkatan</th>
            <th width="120">Aksi</th>
        </tr>
        @foreach($items as $row)
        <tr>
            <td>{{ $row->tingkat }} {{ $row->rombel }}</td>
            <td>{{ $row->jurusan->nama }}</td>
            <td>{{ $row->singkatan }}</td>
            <td>{{ $row->angkatan }}</td>
            <td>
                <a href="{{ route('admin.kelas.destroy',$row->id) }}"
                   onclick="return confirm('Hapus?')"
                   class="btn btn-sm btn-danger">Del</a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
