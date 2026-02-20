@extends('layouts.main')
@section('title', 'Tambah Obat')

@section('content')
<div class="animate-fade-in max-w-xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6">
        <h1 class="text-xl font-bold mb-6 flex items-center gap-2">
            <i data-lucide="plus-circle" class="text-purple-600"></i>
            Tambah Obat
        </h1>

        <form method="POST" action="{{ route('master.medicines.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="pill"></i> Nama Obat
                </label>
                <input type="text" name="name" required
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="package"></i> Satuan
                </label>
                <input type="text" name="unit"
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="wallet"></i> Harga
                </label>
                <input type="number" name="price" required
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="boxes"></i> Stok
                </label>
                <input type="number" name="stock" required
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('master.medicines.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i data-lucide="arrow-left"></i>
                    Kembali
                </a>

                <button class="bg-purple-600 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i data-lucide="save"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
