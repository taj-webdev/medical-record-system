@extends('layouts.main')
@section('title', 'Input Vital Sign')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6 animate-fade-in">

    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
        <i data-lucide="activity"></i>
        Input Vital Sign
    </h2>

    <div class="mb-4 text-sm text-gray-600">
        Pasien:
        <span class="font-semibold text-gray-800">
            {{ $registration->patient_name }}
        </span>
    </div>

    <form
        method="POST"
        action="{{ route('vital.store', $registration->id) }}"
        class="grid grid-cols-1 md:grid-cols-2 gap-4"
    >
        @csrf

        <div>
            <label class="text-sm">Tekanan Darah</label>
            <input name="blood_pressure" class="input" placeholder="120/80" required>
        </div>

        <div>
            <label class="text-sm">Detak Jantung</label>
            <input name="heart_rate" type="number" class="input" required>
        </div>

        <div>
            <label class="text-sm">Suhu (°C)</label>
            <input name="temperature" type="number" step="0.1" class="input" required>
        </div>

        <div>
            <label class="text-sm">Berat Badan (kg)</label>
            <input name="weight" type="number" step="0.1" class="input" required>
        </div>

        <div>
            <label class="text-sm">Tinggi Badan (cm)</label>
            <input name="height" type="number" step="0.1" class="input" required>
        </div>

        <div class="md:col-span-2 flex justify-end gap-2 mt-4">
            <a href="{{ route('dashboard.nurse') }}"
               class="px-4 py-2 rounded bg-gray-200 text-sm flex items-center gap-1">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>

            <button
                class="px-4 py-2 rounded bg-blue-600 text-white text-sm flex items-center gap-1 hover:bg-blue-700"
            >
                <i data-lucide="save"></i>
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
