@extends('layouts.main')
@section('title', 'Tambah Klinik')

@section('content')
<div class="animate-fade-in max-w-2xl">

    <div class="flex items-center gap-2 mb-6">
        <i data-lucide="plus-circle" class="w-6 h-6 text-indigo-600"></i>
        <h1 class="text-2xl font-bold">Tambah Klinik</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form method="POST" action="{{ route('master.clinics.store') }}" class="space-y-5">
            @csrf

            {{-- NAMA KLINIK --}}
            <div>
                <label class="font-semibold flex items-center gap-2 mb-2">
                    <i data-lucide="building-2" class="w-4"></i>
                    Nama Klinik
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-200"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label class="font-semibold flex items-center gap-2 mb-2">
                    <i data-lucide="file-text" class="w-4"></i>
                    Deskripsi
                </label>
                <textarea name="description"
                          rows="3"
                          class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-200">{{ old('description') }}</textarea>
            </div>

            {{-- ACTION BUTTON --}}
            <div class="flex justify-between pt-4">

                <a href="{{ route('master.clinics.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-600">
                    <i data-lucide="arrow-left"></i>
                    Kembali
                </a>

                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg flex items-center gap-2 hover:bg-indigo-700">
                    <i data-lucide="save"></i>
                    Simpan Klinik
                </button>

            </div>

        </form>

    </div>

</div>
@endsection
