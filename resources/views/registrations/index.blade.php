@extends('layouts.main')
@section('title', 'Registrasi & Antrian')

@section('content')
<div class="animate-fade-in">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <i data-lucide="clipboard-list" class="w-6 h-6 text-blue-600"></i>
            Registrasi & Antrian
        </h2>

        <a href="{{ route('registrations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700">
            <i data-lucide="plus"></i>
            Tambah Registrasi
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4 flex items-center gap-2">
        <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Cari NRM / Nama Pasien..."
            class="border rounded-lg px-4 py-2 w-full md:w-1/3"
        >
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3 text-center">Tanggal</th>
                    <th class="p-3 text-center">NRM</th>
                    <th class="p-3 text-center">Nama Pasien</th>
                    <th class="p-3 text-center">Klinik</th>
                    <th class="p-3 text-center">Dokter</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $r)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 text-center">{{ date('d/m/Y H:i', strtotime($r->registration_date)) }}</td>
                    <td class="font-medium text-center">{{ $r->medical_record_number }}</td>
                    <td class="p-3 text-center">{{ $r->patient_name }}</td>
                    <td class="p-3 text-center">{{ $r->clinic_name }}</td>
                    <td class="p-3 text-center">{{ $r->doctor_name ?? '-' }}</td>
                    <td class="p-3 text-center">
                        @if($r->status == 'waiting')
                            <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-700 flex items-center gap-1 w-fit">
                                <i data-lucide="clock" class="w-3 h-3"></i> Menunggu
                            </span>
                        @elseif($r->status == 'examined')
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 flex items-center gap-1 w-fit">
                                <i data-lucide="activity" class="w-3 h-3"></i> Diperiksa
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 flex items-center gap-1 w-fit">
                                <i data-lucide="check-circle" class="w-3 h-3"></i> Selesai
                            </span>
                        @endif
                    </td>
                    <td class="text-center flex justify-center gap-2 py-2">
                        <a href="{{ route('registrations.edit', $r->id) }}" class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600">
                            <i data-lucide="edit"></i>
                        </a>
                        <button onclick="hapus({{ $r->id }})" class="bg-red-600 text-white p-2 rounded hover:bg-red-700">
                            <i data-lucide="trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">
                        Data registrasi belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $registrations->links() }}
    </div>

</div>
@endsection
