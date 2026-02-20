@extends('layouts.main')
@section('title', 'Edit Registrasi')

@section('content')
<div class="animate-fade-in max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <i data-lucide="edit-3" class="w-7 h-7 text-yellow-500"></i>
        <h2 class="text-xl font-semibold">Edit Registrasi Pasien</h2>
    </div>

    <form method="POST" action="{{ route('registrations.update', $registration->id) }}"
          class="bg-white rounded-xl shadow p-6 space-y-5">
        @csrf

        {{-- PASIEN --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2 mb-1">
                <i data-lucide="users" class="w-4 h-4"></i>
                Pasien
            </label>
            <select name="patient_id" required class="w-full border rounded-lg px-4 py-2">
                @foreach($patients as $p)
                    <option value="{{ $p->id }}"
                        @selected($registration->patient_id == $p->id)>
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
                @foreach($clinics as $c)
                    <option value="{{ $c->id }}"
                        @selected($registration->clinic_id == $c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DOKTER --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2 mb-1">
                <i data-lucide="stethoscope" class="w-4 h-4"></i>
                Dokter
            </label>
            <select name="doctor_id" class="w-full border rounded-lg px-4 py-2">
                <option value="">-- Belum Ditentukan --</option>
                @foreach($doctors as $d)
                    <option value="{{ $d->id }}"
                        @selected($registration->doctor_id == $d->id)>
                        {{ $d->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="text-sm font-medium flex items-center gap-2 mb-1">
                <i data-lucide="activity" class="w-4 h-4"></i>
                Status
            </label>
            <select name="status" required class="w-full border rounded-lg px-4 py-2">
                <option value="waiting"   @selected($registration->status=='waiting')>Menunggu</option>
                <option value="examined"  @selected($registration->status=='examined')>Diperiksa</option>
                <option value="completed" @selected($registration->status=='completed')>Selesai</option>
            </select>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('registrations.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 flex items-center gap-2 hover:bg-gray-300">
                <i data-lucide="arrow-left"></i>
                Kembali
            </a>

            <button
                class="px-5 py-2 rounded-lg bg-yellow-500 text-white flex items-center gap-2 hover:bg-yellow-600">
                <i data-lucide="save"></i>
                Update Registrasi
            </button>
        </div>
    </form>

</div>
@endsection
