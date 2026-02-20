@extends('layouts.main')
@section('title','Tambah Role')

@section('content')
<div class="animate-fade-in max-w-xl mx-auto">

    <!-- Header -->
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2 text-gray-800">
        <i data-lucide="plus-circle" class="w-6 h-6 text-blue-600"></i>
        Tambah Role
    </h1>

    <!-- Card Form -->
    <form method="POST" action="{{ route('master.roles.store') }}"
          class="bg-white p-6 rounded-2xl shadow-sm border space-y-5">
        @csrf

        <!-- Nama Role -->
        <div class="space-y-1">
            <label class="font-semibold text-sm text-gray-700">
                Nama Role
            </label>
            <input 
                type="text" 
                name="name"
                value="{{ old('name') }}"
                class="w-full border rounded-xl px-4 py-2.5 text-sm 
                       focus:ring-2 focus:ring-blue-500 focus:outline-none
                       @error('name') border-red-500 @enderror"
                placeholder="Contoh: Admin, Dokter, Kasir"
            >
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div class="space-y-1">
            <label class="font-semibold text-sm text-gray-700">
                Deskripsi
            </label>
            <textarea 
                name="description"
                rows="3"
                class="w-full border rounded-xl px-4 py-2.5 text-sm 
                       focus:ring-2 focus:ring-blue-500 focus:outline-none
                       @error('description') border-red-500 @enderror"
                placeholder="Jelaskan fungsi role ini..."
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('master.roles.index') }}"
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
