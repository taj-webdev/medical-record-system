@extends('layouts.main')
@section('title','Edit User')

@section('content')
<div class="animate-fade-in max-w-xl">

    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i data-lucide="edit"></i>
        Edit User
    </h1>

    <form method="POST" action="{{ route('master.users.update',$user->id) }}"
          class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf

        <input type="text" name="name"
            value="{{ $user->name }}"
            class="w-full border rounded-lg px-3 py-2">

        <input type="text" name="username"
            value="{{ $user->username }}"
            class="w-full border rounded-lg px-3 py-2">

        <input type="email" name="email"
            value="{{ $user->email }}"
            class="w-full border rounded-lg px-3 py-2">

        <input type="password" name="password"
            placeholder="Kosongkan jika tidak diganti"
            class="w-full border rounded-lg px-3 py-2">

        <select name="role_id"
            class="w-full border rounded-lg px-3 py-2">
        @foreach($roles as $role)
            <option value="{{ $role->id }}"
                {{ $role->id == $user->role_id ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
        </select>

    <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i data-lucide="save"></i>
        Update
    </button>

    </form>
</div>
@endsection
