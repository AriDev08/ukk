@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Data')

@section('content')
<div class="max-w-3xl mx-auto">

<div class="bg-white rounded-[2rem] p-10 shadow border border-slate-100">

<h3 class="text-xl font-black mb-6">Edit Kategori</h3>

<form action="{{ route('admin.categories.update',$category->id) }}" method="POST">
@csrf
@method('PUT')

<div class="mb-6">
<label class="block text-sm font-bold mb-2">Nama Kategori</label>
<input type="text"
       name="name"
       value="{{ $category->name }}"
       class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-primary outline-none"
       required>
</div>

<div class="flex gap-3">
<button class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow">
Update
</button>

<a href="{{ route('admin.categories.index') }}"
   class="px-6 py-3 bg-slate-100 rounded-2xl font-bold">
Kembali
</a>
</div>

</form>

</div>
</div>
@endsection
