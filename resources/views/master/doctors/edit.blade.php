@extends('layouts.main')
@section('title', 'Edit Dokter')

@section('content')
<div class="animate-fade-in max-w-2xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-xl font-bold mb-6 flex items-center gap-2">
            <i data-lucide="edit-3" class="text-yellow-600"></i>
            Edit Dokter
        </h1>

        <form method="POST" action="{{ route('master.doctors.update', $doctor->id) }}" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-semibold mb-1 flex items-center gap-1">
                    <i data-lucide="user"></i>
                    Nama Dokter
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $doctor->name) }}"
                       required
                       class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
            </div>

            {{-- Spesialisasi --}}
            <div>
                <label class="block text-sm font-semibold mb-1 flex items-center gap-1">
                    <i data-lucide="stethoscope"></i>
                    Spesialisasi
                </label>
                <input type="text"
                       name="specialization"
                       value="{{ old('specialization', $doctor->specialization) }}"
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block text-sm font-semibold mb-1 flex items-center gap-1">
                    <i data-lucide="phone"></i>
                    Nomor Telepon
                </label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone', $doctor->phone) }}"
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            {{-- Status Aktif --}}
            <div>
                <label class="block text-sm font-semibold mb-2 flex items-center gap-1">
                    <i data-lucide="power"></i>
                    Status
                </label>
                <select name="is_active"
                        class="w-full border rounded-lg px-4 py-2">
                    <option value="1" {{ $doctor->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$doctor->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-between pt-4">
                <a href="{{ route('master.doctors.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-600">
                    <i data-lucide="arrow-left"></i>
                    Kembali
                </a>

                <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-600">
                    <i data-lucide="save"></i>
                    Update
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
