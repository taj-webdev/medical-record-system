@extends('layouts.main')
@section('title', 'Master Dokter')

@section('content')
<div class="animate-fade-in">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <i data-lucide="user-cog" class="w-6 text-blue-600"></i>
            Master Dokter
        </h1>

        <a href="{{ route('master.doctors.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700">
            <i data-lucide="plus-circle"></i>
            Tambah Dokter
        </a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        {{-- SEARCH --}}
        <form method="GET" class="mb-4">
            <div class="flex gap-2">
                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari nama atau spesialis..."
                       class="border rounded-lg px-4 py-2 w-full">
                <button class="bg-gray-700 text-white px-4 rounded-lg">
                    <i data-lucide="search"></i>
                </button>
            </div>
        </form>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-center">Nama</th>
                    <th class="p-3 text-center">Spesialis</th>
                    <th class="p-3 text-center">Telepon</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $doc)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-center font-semibold">{{ $doc->name }}</td>
                    <td class="p-3 text-center">{{ $doc->specialization }}</td>
                    <td class="p-3 text-center">{{ $doc->phone }}</td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center">
                            @if($doc->is_active)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs flex items-center gap-1">
                                    <i data-lucide="x-circle" class="w-3 h-3"></i>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="text-center space-x-2">
                        <a href="{{ route('master.doctors.edit', $doc->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded flex items-center gap-1 inline-flex">
                            <i data-lucide="edit-2" class="w-4"></i>
                        </a>

                        <button onclick="hapusDokter({{ $doc->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded flex items-center gap-1 inline-flex">
                            <i data-lucide="trash-2" class="w-4"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $doctors->links() }}
        </div>

    </div>

</div>

<script>
function hapusDokter(id){
    Swal.fire({
        title: 'Yakin Hapus?',
        text: 'Data Dokter Akan Dihapus',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus'
    }).then((result)=>{
        if(result.isConfirmed){
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/master/dokter/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    })
}
</script>

@endsection
