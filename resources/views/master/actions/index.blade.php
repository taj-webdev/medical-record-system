@extends('layouts.main')
@section('title', 'Master Tindakan Medis')

@section('content')
<div class="animate-fade-in">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="activity" class="text-emerald-600"></i>
            Master Tindakan Medis
        </h1>

        <a href="{{ route('master.actions.create') }}"
           class="bg-emerald-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-emerald-700">
            <i data-lucide="plus-circle"></i>
            Tambah Tindakan
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari nama tindakan..."
                   class="border rounded-lg px-4 py-2 w-full">
            <button class="bg-gray-600 text-white px-4 rounded-lg flex items-center gap-2">
                <i data-lucide="search"></i>
                Cari
            </button>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="p-3 text-center">Nama Tindakan</th>
                    <th class="p-3 text-center">Biaya</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actions as $a)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 text-center font-medium">{{ $a->name }}</td>
                    <td class="p-3 text-center text-emerald-600 font-semibold">
                        Rp {{ number_format($a->cost,0,',','.') }}
                    </td>
                    <td class="p-3 text-center flex justify-center gap-2">

                        <a href="{{ route('master.actions.edit', $a->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded-lg flex items-center gap-1 hover:bg-yellow-600">
                            <i data-lucide="edit-3"></i>
                            Edit
                        </a>

                        <button onclick="hapusAction({{ $a->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded-lg flex items-center gap-1 hover:bg-red-700">
                            <i data-lucide="trash-2"></i>
                            Hapus
                        </button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $actions->links() }}
        </div>
    </div>

</div>

<script>
function hapusAction(id) {
    Swal.fire({
        title: 'Yakin Hapus?',
        text: 'Data Tindakan Medis Akan Dihapus Permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/master/actions/${id}`;
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
