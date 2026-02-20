@extends('layouts.main')
@section('title', 'Input Rekam Medis')

@section('content')
<div class="animate-fade-in max-w-3xl">

    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
        <i data-lucide="file-plus"></i>
        Rekam Medis - {{ $registration->patient_name }}
    </h2>

    <form method="POST" action="{{ route('medical-records.store', $registration->id) }}"
          class="bg-white p-6 rounded-xl shadow space-y-4">
        @csrf

        <div>
            <label class="text-sm font-medium">Keluhan</label>
            <textarea name="complaint" class="w-full border rounded px-3 py-2" required></textarea>
        </div>

        <div>
            <label class="text-sm font-medium">Diagnosis</label>
            <select name="diagnosis_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Diagnosis --</option>
                @foreach($diagnoses as $d)
                    <option value="{{ $d->id }}">{{ $d->code }} - {{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm font-medium">Catatan Dokter</label>
            <textarea name="notes" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        {{-- VITAL SIGN (READ ONLY) --}}
        @if($vitalSign)
        <div class="bg-slate-50 p-4 rounded">
            <h4 class="font-semibold mb-2 flex items-center gap-2">
                <i data-lucide="activity"></i> Vital Sign
            </h4>
            <p>TD: {{ $vitalSign->blood_pressure }}</p>
            <p>Nadi: {{ $vitalSign->heart_rate }}</p>
            <p>Suhu: {{ $vitalSign->temperature }} °C</p>
        </div>
        @endif

        <div class="flex justify-end gap-2">
            <a href="{{ route('medical-records.index') }}"
               class="px-4 py-2 rounded border">Kembali</a>

            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <i data-lucide="save" class="inline w-4 h-4"></i>
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection
