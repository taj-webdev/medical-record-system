@extends('layouts.main')
@section('title', 'Rekam Medis')

@section('content')
<div class="animate-fade-in">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="stethoscope" class="w-6 h-6 text-blue-600"></i>
            Rekam Medis Pasien
        </h1>
    </div>

    {{-- FILTER SECTION --}}
    <form method="GET" class="bg-white p-4 rounded-xl shadow mb-6">
        <div class="grid md:grid-cols-5 gap-3 items-end">

            {{-- SEARCH --}}
            <div>
                <label class="text-xs text-gray-500">Cari</label>
                <div class="relative">
                    <i data-lucide="search"
                       class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           class="pl-9 pr-3 py-2 w-full border rounded-lg text-sm">
                </div>
            </div>

            {{-- DATE FROM --}}
            <div>
                <label class="text-xs text-gray-500">Dari Tanggal</label>
                <input type="date"
                       name="date_from"
                       value="{{ $dateFrom ?? '' }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            {{-- DATE TO --}}
            <div>
                <label class="text-xs text-gray-500">Sampai Tanggal</label>
                <input type="date"
                       name="date_to"
                       value="{{ $dateTo ?? '' }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            {{-- FILTER DOCTOR (ADMIN ONLY) --}}
            @if(session('user.role_id') == 1)
            <div>
                <label class="text-xs text-gray-500">Doctor</label>
                <select name="doctor_id"
                        class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Doctor</option>
                    @foreach($doctors as $d)
                        <option value="{{ $d->id }}"
                            {{ ($doctorFilter ?? '') == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- BUTTON --}}
            <div class="flex gap-2">

                <button class="flex-1 bg-blue-600 text-white rounded-lg py-2 text-sm flex items-center justify-center gap-1 hover:bg-blue-700">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                    Filter
                </button>

                <a href="{{ request()->fullUrlWithQuery(['export' => 'pdf']) }}"
                   class="flex-1 bg-red-600 text-white rounded-lg py-2 text-sm flex items-center justify-center gap-1 hover:bg-red-700">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    PDF
                </a>

            </div>

        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-center">No RM</th>
                    <th class="px-4 py-3 text-center">Pasien</th>
                    <th class="px-4 py-3 text-center">Tanggal</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($registrations as $r)
                <tr class="hover:bg-gray-50 transition">

                    <td class="px-4 py-3 text-center font-medium">
                        {{ $r->medical_record_number }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ $r->patient_name }}
                    </td>

                    <td class="px-4 py-3 text-center text-gray-600">
                        {{ date('d/m/Y H:i', strtotime($r->registration_date)) }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($r->medical_record_id)
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                ✔ Sudah Diperiksa
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                ⏳ Menunggu
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2 flex-wrap">

                            @if(!$r->medical_record_id)

                                {{-- PERIKSA --}}
                                <a href="{{ route('medical-records.create', $r->id) }}"
                                   class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700 flex items-center gap-1">
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                    Periksa
                                </a>

                            @else

                                {{-- TINDAKAN --}}
                                <a href="{{ route('medical-actions.index', $r->medical_record_id) }}"
                                   class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700 flex items-center gap-1">
                                    <i data-lucide="activity" class="w-4 h-4"></i>
                                    Tindakan
                                </a>

                                {{-- RESEP --}}
                                <a href="{{ route('prescriptions.index', $r->medical_record_id) }}"
                                   class="px-3 py-1.5 bg-purple-600 text-white rounded-lg text-xs hover:bg-purple-700 flex items-center gap-1">
                                    <i data-lucide="pill" class="w-4 h-4"></i>
                                    Resep
                                </a>

                                {{-- GENERATE INVOICE (ADMIN ONLY) --}}
                                @if(session('user.role_id') == 1)
                                <form method="POST"
                                      action="{{ route('billing.generate', $r->id) }}">
                                    @csrf
                                    <button
                                        class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs hover:bg-emerald-700 flex items-center gap-1">
                                        <i data-lucide="receipt" class="w-4 h-4"></i>
                                        Invoice
                                    </button>
                                </form>
                                @endif

                            @endif

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">
                        Tidak ada data pasien
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $registrations->links() }}
    </div>

</div>
@endsection
