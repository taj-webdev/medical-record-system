@extends('layouts.main')
@section('title', 'Resep & Obat')

@section('content')
<div class="animate-fade-in max-w-4xl">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="pill" class="w-6 h-6 text-purple-600"></i>
            Resep Obat
        </h2>
        <span class="text-gray-600 text-sm">
            Pasien: <strong>{{ $medicalRecord->patient_name }}</strong>
        </span>
    </div>

    {{-- FORM (DOCTOR ONLY) --}}
    @if($roleId == 2)
    <form method="POST"
          action="{{ route('prescriptions.store', $medicalRecord->id) }}"
          class="bg-white p-6 rounded-xl shadow mb-6">
        @csrf

        <div class="grid grid-cols-3 gap-4 items-end">

            <div>
                <label class="text-xs text-gray-500">Pilih Obat</label>
                <select name="medicine_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200"
                        required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($medicines as $m)
                        <option value="{{ $m->id }}">
                            {{ $m->name }} ({{ $m->unit }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-xs text-gray-500">Jumlah</label>
                <input type="number"
                       name="quantity"
                       min="1"
                       class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-green-200"
                       required>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-green-600 text-white rounded-lg py-2 hover:bg-green-700 flex items-center justify-center gap-1">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah
                </button>
            </div>

        </div>
    </form>
    @endif

    {{-- LIST OBAT --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4">Daftar Obat</h4>

        @php $total = 0; @endphp

        @forelse($items as $i)
            @php
                $subtotal = $i->price * $i->quantity;
                $total += $subtotal;
            @endphp

            <div class="flex justify-between items-center border-b py-3 text-sm">
                <div>
                    <p class="font-medium">{{ $i->name }}</p>
                    <p class="text-gray-500 text-xs">
                        Qty: {{ $i->quantity }}
                    </p>
                </div>
                <div class="text-right">
                    <p>Rp {{ number_format($subtotal,0,',','.') }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm">
                Belum ada obat ditambahkan
            </p>
        @endforelse

        @if(count($items) > 0)
        <div class="flex justify-between mt-4 pt-4 border-t font-semibold">
            <span>Total Obat</span>
            <span>Rp {{ number_format($total,0,',','.') }}</span>
        </div>
        @endif
    </div>

</div>
@endsection
