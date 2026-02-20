@extends('layouts.main')
@section('title','Edit Role')

@section('content')
<div class="animate-fade-in max-w-xl">

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i data-lucide="edit"></i>
        Edit Role
    </h1>

    <form method="POST" action="{{ route('master.roles.update',$role->id) }}"
          class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf

    <div>
        <label class="font-semibold">Nama Role</label>
        <input type="text" name="name"
        value="{{ $role->name }}"
        class="w-full border rounded-lg px-3 py-2">
    </div>

    <div>
        <label class="font-semibold">Deskripsi</label>
            <textarea name="description"
            class="w-full border rounded-lg px-3 py-2">{{ $role->description }}</textarea>
    </div>

        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i data-lucide="save"></i>
            Update
        </button>

    </form>
</div>
@endsection
