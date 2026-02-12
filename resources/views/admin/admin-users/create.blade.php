@extends('layouts.app')

@section('title','Tambah Admin')
@section('page_title','Tambah Admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-10 rounded-[2rem] border shadow">

<form action="{{ route('admin.admin-users.store') }}" method="POST" class="space-y-6">
@csrf

<input name="name" placeholder="Nama Admin"
class="w-full px-5 py-3 rounded-2xl border" required>

<input name="email" type="email" placeholder="Email"
class="w-full px-5 py-3 rounded-2xl border" required>

<input name="password" type="password" placeholder="Password"
class="w-full px-5 py-3 rounded-2xl border" required>

<button class="px-6 py-3 bg-darkNavy text-white rounded-2xl font-bold">
Simpan
</button>

</form>

</div>
@endsection
