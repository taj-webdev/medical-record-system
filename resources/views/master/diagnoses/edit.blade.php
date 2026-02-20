@extends('layouts.main')
@section('title', 'Edit Diagnosa')

@section('content')
<div class="animate-fade-in max-w-xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6">
        <h1 class="text-xl font-bold mb-6 flex items-center gap-2">
            <i data-lucide="edit-3" class="text-yellow-600"></i>
            Edit Diagnosa
        </h1>

        <form method="POST" action="{{ route('master.diagnoses.update', $diagnosis->id) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="hash"></i>
                    Kode
                </label>
                <input type="text"
                       name="code"
                       value="{{ $diagnosis->code }}"
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="block mb-1 flex items-center gap-1">
                    <i data-lucide="file-text"></i>
                    Nama Diagnosa
                </label>
                <input type="text"
                       name="name"
                       value="{{ $diagnosis->name }}"
                       required
                       class="w-full border rounded-lg px-4 py-2">
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('master.diagnoses.index') }}"
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
