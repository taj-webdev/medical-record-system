@extends('layouts.main')
@section('title', 'Edit Pasien')

@section('content')
<div class="animate-fade-in max-w-3xl mx-auto">

    <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
        <i data-lucide="user-cog" class="w-6 h-6 text-yellow-600"></i>
        Edit Pasien
    </h2>

    <form method="POST" action="{{ route('patients.update', $patient->id) }}"
          class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="user"></i>
                Nama Lengkap
            </label>
            <input type="text" name="name" value="{{ $patient->name }}" required
                class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- NIK --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="credit-card"></i>
                NIK
            </label>
            <input type="text" name="nik" value="{{ $patient->nik }}"
                class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- Gender --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="users"></i>
                Jenis Kelamin
            </label>
            <select name="gender" class="w-full mt-1 border rounded-lg px-4 py-2">
                <option value="M" @selected($patient->gender == 'M')>Laki-laki</option>
                <option value="F" @selected($patient->gender == 'F')>Perempuan</option>
            </select>
        </div>

        {{-- Tanggal Lahir --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="calendar"></i>
                Tanggal Lahir
            </label>
            <input type="date" name="birth_date"
                   value="{{ $patient->birth_date }}"
                   class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- Telepon --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="phone"></i>
                No. Telepon
            </label>
            <input type="text" name="phone"
                   value="{{ $patient->phone }}"
                   class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- Alamat --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="map-pin"></i>
                Alamat
            </label>
            <textarea name="address" rows="3"
                class="w-full mt-1 border rounded-lg px-4 py-2">{{ $patient->address }}</textarea>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('patients.index') }}"
               class="px-4 py-2 rounded-lg border flex items-center gap-2">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>

            <button class="bg-yellow-500 text-white px-5 py-2 rounded-lg flex items-center gap-2 hover:bg-yellow-600">
                <i data-lucide="save"></i>
                Update
            </button>
        </div>

    </form>
</div>
@endsection
