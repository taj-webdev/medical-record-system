@extends('layouts.main')
@section('title', 'Master Klinik')

@section('content')
<div class="animate-fade-in">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="building-2"></i>
            Master Klinik
        </h1>

        <a href="{{ route('master.clinics.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-indigo-700">
            <i data-lucide="plus"></i>
            Tambah Klinik
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}"
                placeholder="Cari Klinik..."
                class="border rounded px-3 py-2 w-full">
            <button class="bg-gray-800 text-white px-4 rounded flex items-center gap-2">
                <i data-lucide="search"></i> Cari
            </button>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-center">Nama Klinik</th>
                    <th class="p-3 text-center">Deskripsi</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clinics as $clinic)
                <tr class="border-t">
                    <td class="p-3 text-center">{{ $clinic->name }}</td>
                    <td class="p-3 text-center">{{ $clinic->description }}</td>
                    <td class="p-3 text-center flex justify-center gap-2">
                        <a href="{{ route('master.clinics.edit', $clinic->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded flex items-center gap-1">
                            <i data-lucide="edit-3" class="w-4"></i> Edit
                        </a>

                        <button onclick="hapusKlinik({{ $clinic->id }})"
                           class="bg-red-600 text-white px-3 py-1 rounded flex items-center gap-1">
                            <i data-lucide="trash-2" class="w-4"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center p-6 text-gray-400">
                        Data Tidak Ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $clinics->links() }}
        </div>
    </div>

</div>

<script>
function hapusKlinik(id) {
    Swal.fire({
        title: 'Yakin Hapus?',
        text: 'Data Klinik Akan Dihapus Permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/master/clinics/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    })
}
</script>

@endsection
