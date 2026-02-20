@extends('layouts.main')
@section('title','Tambah User')

@section('content')
<div class="animate-fade-in max-w-xl mx-auto">

    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-gray-800">
        <i data-lucide="user-plus" class="w-6 h-6 text-blue-600"></i>
        Tambah User
    </h1>

    <!-- Form Card -->
    <form method="POST" 
          action="{{ route('master.users.store') }}"
          class="bg-white p-6 rounded-2xl shadow-sm border space-y-5">
        @csrf

        <!-- Nama -->
        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700">
                Nama Lengkap
            </label>
            <input type="text" 
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Masukkan nama lengkap"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm
                          focus:ring-2 focus:ring-blue-500 focus:outline-none
                          @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Username -->
        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700">
                Username
            </label>
            <input type="text" 
                   name="username"
                   value="{{ old('username') }}"
                   placeholder="Masukkan username"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm
                          focus:ring-2 focus:ring-blue-500 focus:outline-none
                          @error('username') border-red-500 @enderror">
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700">
                Email
            </label>
            <input type="email" 
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="Masukkan email aktif"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm
                          focus:ring-2 focus:ring-blue-500 focus:outline-none
                          @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700">
                Password
            </label>
            <input type="password" 
                   name="password"
                   placeholder="Minimal 8 karakter"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm
                          focus:ring-2 focus:ring-blue-500 focus:outline-none
                          @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Role -->
        <div class="space-y-1">
            <label class="text-sm font-semibold text-gray-700">
                Role
            </label>
            <select name="role_id"
                class="w-full border rounded-xl px-4 py-2.5 text-sm
                       focus:ring-2 focus:ring-blue-500 focus:outline-none
                       @error('role_id') border-red-500 @enderror">
                <option value="">-- Pilih Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}"
                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('master.users.index') }}"
               class="px-4 py-2 rounded-xl border text-gray-600 
                      hover:bg-gray-100 text-sm">
                Batal
            </a>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 
                       text-white px-5 py-2 rounded-xl 
                       flex items-center gap-2 text-sm 
                       shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i>
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection
