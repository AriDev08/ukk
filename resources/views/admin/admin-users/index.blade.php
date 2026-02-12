@extends('layouts.app')

@section('title','Manajemen Admin')
@section('page_title','Pusat Kendali Admin')

@section('content')
<div class="space-y-10">

<div class="flex justify-between items-center">
    <div>
        <h3 class="text-2xl font-black">Manajemen Admin</h3>
        <p class="text-sm text-slate-500">
            Total <span class="text-primary font-bold">{{ $admins->total() }}</span> admin
        </p>
    </div>

    <a href="{{ route('admin.admin-users.create') }}"
       class="px-6 py-3 bg-darkNavy text-white rounded-2xl font-bold shadow">
        Tambah Admin
    </a>
</div>

<div class="bg-white rounded-[2.5rem] overflow-hidden border shadow-sm">
<table class="w-full">
<thead class="bg-slate-50 text-[10px] uppercase text-slate-400">
<tr>
    <th class="px-8 py-5">Nama</th>
    <th>Email</th>
    <th class="text-right px-8">Aksi</th>
</tr>
</thead>
<tbody class="divide-y">

@foreach($admins as $admin)
<tr class="hover:bg-slate-50">
    <td class="px-8 py-6 font-bold">{{ $admin->name }}</td>
    <td>{{ $admin->email }}</td>
    <td class="px-8 text-right space-x-2">
        <a href="{{ route('admin.admin-users.edit',$admin->id) }}"
           class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold">
           Edit
        </a>

        <form method="POST"
              action="{{ route('admin.admin-users.destroy',$admin->id) }}"
              class="inline">
            @csrf @method('DELETE')
            <button onclick="return confirm('Hapus admin?')"
                    class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-bold">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach

</tbody>
</table>
</div>

{{ $admins->links() }}

</div>
@endsection
