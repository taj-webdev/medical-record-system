@extends('layouts.main')
@section('title', 'Edit Tindakan Medis')

@section('content')
<div class="animate-fade-in max-w-xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6">
        <h1 class="text-xl font-bold mb-6 flex items-center gap-2">
            <i data-lucide="edit-3" class="text-yellow-600"></i>
            Edit Tindakan Medis
        </h1>

        <form method="POST" action="{{ route('master.actions.update', $action->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="file-text"></i>
                    Nama Tindakan
                </label>
                <input type="text" name="name"
                       value="{{ $action->name }}"
                       required
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="wallet"></i>
                    Biaya
                </label>
                <input type="number" name="cost"
                       value="{{ $action->cost }}"
                       required
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('master.actions.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i data-lucide="arrow-left"></i>
                    Kembali
                </a>

                <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg flex items-center gap-2">
                    <i data-lucide="save"></i>
                    Update
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
