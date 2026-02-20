@extends('layouts.main')
@section('title', 'Tambah Registrasi')

@section('content')
<div class="animate-fade-in max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <i data-lucide="plus-circle" class="w-7 h-7 text-blue-600"></i>
        <h2 class="text-xl font-semibold">Tambah Registrasi Pasien</h2>
    </div>

    <form method="POST" action="{{ route('registrations.store') }}" class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf

        {{-- PASIEN --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2 mb-1">
                <i data-lucide="users" class="w-4 h-4"></i>
                Pasien
            </label>
            <select name="patient_id" required class="w-full border rounded-lg px-4 py-2">
                <option value="">-- Pilih Pasien --</option>
                @foreach($patients as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->medical_record_number }} - {{ $p->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- KLINIK --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2 mb-1">
                <i data-lucide="building-2" class="w-4 h-4"></i>
                Klinik / Poli
            </label>
            <select name="clinic_id" required class="w-full border rounded-lg px-4 py-2">
                <option value="">-- Pilih Klinik --</option>
                @foreach($clinics as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- DOKTER --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2 mb-1">
                <i data-lucide="stethoscope" class="w-4 h-4"></i>
                Dokter (Opsional)
            </label>
            <select name="doctor_id" class="w-full border rounded-lg px-4 py-2">
                <option value="">-- Belum Ditentukan --</option>
                @foreach($doctors as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- TANGGAL --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2 mb-1">
                <i data-lucide="calendar-clock" class="w-4 h-4"></i>
                Tanggal Registrasi
            </label>
            <input
                type="datetime-local"
                name="registration_date"
                value="{{ now()->format('Y-m-d\TH:i') }}"
                required
                class="w-full border rounded-lg px-4 py-2"
            >
        </div>

        {{-- ACTION --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('registrations.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 flex items-center gap-2 hover:bg-gray-300">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>

            <button
                class="px-5 py-2 rounded-lg bg-blue-600 text-white flex items-center gap-2 hover:bg-blue-700">
                <i data-lucide="save"></i>
                Simpan Registrasi
            </button>
        </div>
    </form>

</div>
@endsection
