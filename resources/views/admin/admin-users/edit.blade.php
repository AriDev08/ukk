@extends('layouts.app')

@section('title','Edit Admin')
@section('page_title','Edit Admin')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-10 rounded-[2rem] border shadow">

<form action="{{ route('admin.admin-users.update',$admin->id) }}" method="POST" class="space-y-6">
@csrf @method('PUT')

<input name="name" value="{{ $admin->name }}"
class="w-full px-5 py-3 rounded-2xl border" required>

<input name="email" value="{{ $admin->email }}"
class="w-full px-5 py-3 rounded-2xl border" required>

<input name="password" type="password" placeholder="Password baru (opsional)"
class="w-full px-5 py-3 rounded-2xl border">

<button class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold">
Update
</button>

</form>

</div>
@endsection
