@extends('layouts.main')
@section('title', 'Data Pasien')

@section('content')
<div class="animate-fade-in">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            Data Pasien
        </h2>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4 flex items-center gap-2">
        <i data-lucide="search" class="w-5 h-5 text-gray-500"></i>
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Cari NRM / Nama / NIK..."
            class="border rounded-lg px-4 py-2 w-full md:w-1/3"
        >
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3 text-center">NRM</th>
                    <th class="p-3 text-center">Nama</th>
                    <th class="p-3 text-center">NIK</th>
                    <th class="p-3 text-center">Gender</th>
                    <th class="p-3 text-center">Telepon</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $p)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 font-medium text-center">{{ $p->medical_record_number }}</td>
                    <td class="p-3 text-center">{{ $p->name }}</td>
                    <td class="p-3 text-center">{{ $p->nik ?? '-' }}</td>
                    <td class="p-3 text-center">{{ $p->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="p-3 text-center">{{ $p->phone ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        Tidak ada data pasien
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $patients->links() }}
    </div>

</div>
@endsection
