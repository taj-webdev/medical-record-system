@extends('layouts.main')
@section('title', 'Tambah Pasien')

@section('content')
<div class="animate-fade-in max-w-3xl mx-auto">

    <h2 class="text-xl font-semibold mb-6 flex items-center gap-2">
        <i data-lucide="user-plus" class="w-6 h-6 text-blue-600"></i>
        Tambah Pasien
    </h2>

    <form method="POST" action="{{ route('patients.store') }}"
          class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf

        {{-- NRM --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="hash" class="w-4 h-4"></i>
                Nomor Rekam Medis
            </label>
            <input type="text" name="medical_record_number" required
                class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- Nama --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4"></i>
                Nama Lengkap
            </label>
            <input type="text" name="name" required
                class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- NIK --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="credit-card" class="w-4 h-4"></i>
                NIK
            </label>
            <input type="text" name="nik"
                class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- Gender --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="users" class="w-4 h-4"></i>
                Jenis Kelamin
            </label>
            <select name="gender" required
                class="w-full mt-1 border rounded-lg px-4 py-2">
                <option value="">-- Pilih --</option>
                <option value="M">Laki-laki</option>
                <option value="F">Perempuan</option>
            </select>
        </div>

        {{-- Tanggal Lahir --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                Tanggal Lahir
            </label>
            <input type="date" name="birth_date"
                class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- Telepon --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="phone" class="w-4 h-4"></i>
                No. Telepon
            </label>
            <input type="text" name="phone"
                class="w-full mt-1 border rounded-lg px-4 py-2">
        </div>

        {{-- Alamat --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
                Alamat
            </label>
            <textarea name="address" rows="3"
                class="w-full mt-1 border rounded-lg px-4 py-2"></textarea>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('patients.index') }}"
               class="px-4 py-2 rounded-lg border flex items-center gap-2">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>

            <button class="bg-blue-600 text-white px-5 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700">
                <i data-lucide="save"></i>
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection
