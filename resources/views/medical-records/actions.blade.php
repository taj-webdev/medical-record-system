@extends('layouts.main')
@section('title', 'Tindakan Medis')

@section('content')
<div class="animate-fade-in max-w-3xl">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="activity" class="w-6 h-6 text-blue-600"></i>
            Tindakan Medis
        </h2>
        <span class="text-sm text-gray-600">
            Pasien: <strong>{{ $medicalRecord->patient_name }}</strong>
        </span>
    </div>

    {{-- FORM (DOCTOR ONLY) --}}
    @if($roleId == 2)
    <form method="POST"
          action="{{ route('medical-actions.store', $medicalRecord->id) }}"
          class="bg-white p-6 rounded-xl shadow mb-6">
        @csrf

        <label class="text-sm font-medium text-gray-600">Pilih Tindakan</label>

        <div class="flex gap-2 mt-2">
            <select name="medical_action_id"
                    class="flex-1 border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                <option value="">-- Pilih --</option>
                @foreach($actions as $a)
                    <option value="{{ $a->id }}">
                        {{ $a->name }} (Rp {{ number_format($a->cost,0,',','.') }})
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-1">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah
            </button>
        </div>
    </form>
    @endif

    {{-- LIST --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4">Tindakan Dilakukan</h4>

        @php $total = 0; @endphp

        @forelse($selectedActions as $s)
            @php $total += $s->cost; @endphp

            <div class="flex justify-between border-b py-3 text-sm">
                <span>{{ $s->name }}</span>
                <span>Rp {{ number_format($s->cost,0,',','.') }}</span>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada tindakan</p>
        @endforelse

        @if(count($selectedActions) > 0)
        <div class="flex justify-between mt-4 pt-4 border-t font-semibold">
            <span>Total Tindakan</span>
            <span>Rp {{ number_format($total,0,',','.') }}</span>
        </div>
        @endif
    </div>

</div>
@endsection
