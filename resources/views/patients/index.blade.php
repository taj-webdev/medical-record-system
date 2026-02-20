@extends('layouts.main')
@section('title', 'Data Pasien')

@section('content')
<div class="animate-fade-in">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold flex items-center gap-2">
            <i data-lucide="users" class="w-6 h-6 text-red-600"></i>
            Data Pasien
        </h2>

        <a href="{{ route('patients.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700">
            <i data-lucide="plus"></i> Tambah Pasien
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4">
        <input type="text" name="search" value="{{ $search }}"
            placeholder="Cari NRM / Nama / NIK..."
            class="border rounded-lg px-4 py-2 w-full md:w-1/3">
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
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $p)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 text-center">{{ $p->medical_record_number }}</td>
                    <td class="p-3 text-center">{{ $p->name }}</td>
                    <td class="p-3 text-center">{{ $p->nik }}</td>
                    <td class="p-3 text-center">{{ $p->gender }}</td>
                    <td class="p-3 text-center">{{ $p->phone }}</td>
                    <td class="text-center flex justify-center gap-2 py-2">
                        <a href="{{ route('patients.edit', $p->id) }}"
                           class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600">
                            <i data-lucide="edit"></i>
                        </a>
                        <button onclick="hapus({{ $p->id }})" class="bg-red-600 text-white p-2 rounded">
                            <i data-lucide="trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $patients->links() }}
    </div>
</div>
@endsection
