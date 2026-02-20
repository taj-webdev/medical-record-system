@extends('layouts.main')
@section('title','Master Role')

@section('content')
<div class="animate-fade-in">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700 flex items-center gap-2">
            <i data-lucide="shield-check"></i>
            Master Role
        </h1>

        <a href="{{ route('master.roles.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow">
            <i data-lucide="plus-circle"></i>
            Tambah Role
        </a>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ $search }}"
            placeholder="Cari Role..."
            class="border rounded-lg px-3 py-2 w-64 focus:ring focus:ring-blue-200">

        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i data-lucide="search"></i>
            Cari
        </button>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-center">Nama Role</th>
                    <th class="px-4 py-3 text-center">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-center font-semibold">{{ $role->name }}</td>
                    <td class="px-4 py-3 text-center">{{ $role->description }}</td>
                    <td class="px-4 py-3 text-center flex justify-center gap-2">

                        <a href="{{ route('master.roles.edit',$role->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg flex items-center gap-1">
                            <i data-lucide="edit"></i>
                        </a>

                        <button onclick="hapusRole({{ $role->id }})"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg flex items-center gap-1">
                            <i data-lucide="trash-2"></i>
                        </button>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-6 text-gray-500">
                        Data Tidak Ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $roles->links() }}
    </div>

</div>

<script>
function hapusRole(id){
    Swal.fire({
        title:'Hapus Role?',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Ya Hapus'
    }).then(result=>{
        if(result.isConfirmed){
            const form=document.createElement('form');
            form.method='POST';
            form.action=`/master/roles/${id}`;
            form.innerHTML=`@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    })
}
</script>
@endsection
