@extends('layouts.app')

@section('content')
<h3>Dashboard Siswa</h3>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card-box text-center">
            <h5>Total Aspirasi</h5>
            <h2>{{ \App\Models\Aspirasi::where('user_id', auth()->id())->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-box text-center">
            <h5>Dalam Proses</h5>
            <h2>{{ \App\Models\Aspirasi::where('user_id', auth()->id())->where('status','process')->count() }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-box text-center">
            <h5>Selesai</h5>
            <h2>{{ \App\Models\Aspirasi::where('user_id', auth()->id())->where('status','done')->count() }}</h2>
        </div>
    </div>
</div>
@endsection
