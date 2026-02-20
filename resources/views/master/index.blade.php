@extends('layouts.main')
@section('title', 'Master Data')

@section('content')
<div class="animate-fade-in">

    {{-- PAGE TITLE --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
            <i data-lucide="database" class="w-7 h-7 text-indigo-600"></i>
            Master Data Management
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Kelola seluruh data referensi sistem.
        </p>
    </div>

    {{-- CARD GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- KLINIK --}}
        <a href="{{ route('master.clinics.index') }}"
           class="group bg-white rounded-xl shadow p-6 transition hover:shadow-lg hover:-translate-y-1 animate-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg text-gray-700">Klinik</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola data klinik
                    </p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-100 group-hover:bg-blue-200 transition">
                    <i data-lucide="building-2" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </a>

        {{-- DOKTER --}}
        <a href="{{ route('master.doctors.index') }}"
           class="group bg-white rounded-xl shadow p-6 transition hover:shadow-lg hover:-translate-y-1 animate-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg text-gray-700">Dokter</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola data dokter
                    </p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 group-hover:bg-green-200 transition">
                    <i data-lucide="user-round" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </a>

        {{-- DIAGNOSA --}}
        <a href="{{ route('master.diagnoses.index') }}"
           class="group bg-white rounded-xl shadow p-6 transition hover:shadow-lg hover:-translate-y-1 animate-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg text-gray-700">Diagnosa</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola data diagnosa medis
                    </p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-purple-100 group-hover:bg-purple-200 transition">
                    <i data-lucide="clipboard-check" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </a>

        {{-- TINDAKAN MEDIS --}}
        <a href="{{ route('master.actions.index') }}"
           class="group bg-white rounded-xl shadow p-6 transition hover:shadow-lg hover:-translate-y-1 animate-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg text-gray-700">Tindakan Medis</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola biaya & tindakan
                    </p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-orange-100 group-hover:bg-orange-200 transition">
                    <i data-lucide="activity" class="w-6 h-6 text-orange-600"></i>
                </div>
            </div>
        </a>

        {{-- OBAT --}}
        <a href="{{ route('master.medicines.index') }}"
           class="group bg-white rounded-xl shadow p-6 transition hover:shadow-lg hover:-translate-y-1 animate-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg text-gray-700">Obat</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola stok & harga obat
                    </p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-emerald-100 group-hover:bg-emerald-200 transition">
                    <i data-lucide="pill" class="w-6 h-6 text-emerald-600"></i>
                </div>
            </div>
        </a>

        {{-- USER MANAGEMENT --}}
        <a href="{{ route('master.users.index') }}"
           class="group bg-white rounded-xl shadow p-6 transition hover:shadow-lg hover:-translate-y-1 animate-card">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg text-gray-700">Manajemen User</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola akun & role sistem
                    </p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-indigo-100 group-hover:bg-indigo-200 transition">
                    <i data-lucide="users-2" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </a>

    </div>

</div>
@endsection
