@extends('layouts.main')
@section('title','Master User')

@section('content')
<div class="animate-fade-in">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold flex items-center gap-2 text-gray-800">
            <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            Master User
        </h1>

        <a href="{{ route('master.users.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white 
                  px-5 py-2 rounded-xl flex items-center gap-2 
                  shadow-sm transition text-sm">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Tambah User
        </a>
    </div>

    <!-- Search -->
    <form method="GET" class="mb-5 flex gap-3">
        <div class="relative">
            <input type="text" 
                   name="search" 
                   value="{{ $search }}"
                   placeholder="Cari nama atau username..."
                   class="border rounded-xl px-4 py-2 text-sm w-72
                          focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <button type="submit"
            class="bg-gray-800 hover:bg-gray-900 text-white 
                   px-4 py-2 rounded-xl flex items-center gap-2 
                   text-sm transition">
            <i data-lucide="search" class="w-4 h-4"></i>
            Cari
        </button>
    </form>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-5 py-3 text-center">Nama</th>
                    <th class="px-5 py-3 text-center">Username</th>
                    <th class="px-5 py-3 text-center">Role</th>
                    <th class="px-5 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-5 py-3 text-center font-medium text-gray-800">
                        {{ $user->name }}
                    </td>

                    <td class="px-5 py-3 text-center text-gray-600">
                        {{ $user->username }}
                    </td>

                    <td class="px-5 py-3 text-center">
                        <span class="px-3 py-1 rounded-full text-xs 
                                     bg-indigo-100 text-indigo-700 font-semibold">
                            {{ $user->role_name }}
                        </span>
                    </td>

                    <!-- Aksi -->
                    <td class="px-5 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('master.users.edit',$user->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 
                                      text-white px-3 py-1.5 rounded-lg 
                                      flex items-center transition">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>

                            <button onclick="hapusUser({{ $user->id }})"
                                class="bg-red-600 hover:bg-red-700 
                                       text-white px-3 py-1.5 rounded-lg 
                                       flex items-center transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" 
                        class="text-center py-10 text-gray-400">
                        Data Tidak Ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>


<!-- Delete Script -->
<script>
function hapusUser(id){
    Swal.fire({
        title: 'Hapus User?',
        text: 'Data yang dihapus tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus'
    }).then(result => {
        if(result.isConfirmed){
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/master/users/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

@endsection
