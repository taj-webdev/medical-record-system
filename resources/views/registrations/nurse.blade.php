@extends('layouts.main')
@section('title', 'Registrasi & Antrian')

@section('content')
<div class="animate-fade-in">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i data-lucide="clipboard-list" class="w-6 h-6 text-blue-600"></i>
            Registrasi & Antrian
        </h1>

        {{-- SEARCH --}}
        <form method="GET" class="flex gap-2">
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Cari Nama / No RM..."
                class="px-3 py-2 border rounded-lg text-sm focus:ring focus:ring-blue-200"
            >
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                Cari
            </button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3 text-center">No RM</th>
                    <th class="px-4 py-3 text-center">Nama Pasien</th>
                    <th class="px-4 py-3 text-center">Poli</th>
                    <th class="px-4 py-3 text-center">Dokter</th>
                    <th class="px-4 py-3 text-center">Jam Daftar</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Vital Sign</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($registrations as $row)
                <tr class="hover:bg-gray-50 transition">

                    {{-- NO --}}
                    <td class="px-4 py-3 text-center">
                        {{ $loop->iteration + ($registrations->currentPage()-1)*$registrations->perPage() }}
                    </td>

                    {{-- NO RM --}}
                    <td class="px-4 py-3 text-center font-medium">
                        {{ $row->medical_record_number }}
                    </td>

                    {{-- NAMA --}}
                    <td class="px-4 py-3 text-center">
                        {{ $row->patient_name }}
                    </td>

                    {{-- POLI --}}
                    <td class="px-4 py-3 text-center">
                        {{ $row->clinic_name }}
                    </td>

                    {{-- DOKTER --}}
                    <td class="px-4 py-3 text-center">
                        {{ $row->doctor_name ?? '-' }}
                    </td>

                    {{-- JAM --}}
                    <td class="px-4 py-3 text-center text-gray-600">
                        {{ date('H:i', strtotime($row->registration_date)) }}
                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 py-3 text-center">
                        @if($row->status === 'waiting')
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 inline-flex items-center gap-1">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                Waiting
                            </span>
                        @elseif($row->status === 'examined')
                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 inline-flex items-center gap-1">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Siap Dokter
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 inline-flex items-center gap-1">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                Selesai
                            </span>
                        @endif
                    </td>

                    {{-- VITAL --}}
                    <td class="px-4 py-3 text-center">
                        @if($row->vital_id)
                            <span class="text-emerald-600 inline-flex items-center gap-1 text-xs font-medium">
                                <i data-lucide="activity" class="w-4 h-4"></i>
                                Sudah
                            </span>
                        @else
                            <span class="text-red-500 inline-flex items-center gap-1 text-xs font-medium">
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                Belum
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">

                            {{-- INPUT VITAL --}}
                            @if(!$row->vital_id)
                                <a href="{{ route('vital.create', $row->id) }}"
                                   class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg flex items-center gap-1 text-xs hover:bg-emerald-700 transition">
                                    <i data-lucide="activity" class="w-4 h-4"></i>
                                    Vital
                                </a>
                            @endif

                            {{-- KIRIM KE DOKTER --}}
                            @if($row->status === 'waiting' && $row->vital_id)
                                <form id="send-form-{{ $row->id }}"
                                      action="{{ route('registrations.sendDoctor', $row->id) }}"
                                      method="POST">
                                    @csrf

                                    <button type="button"
                                            onclick="confirmSend({{ $row->id }})"
                                            class="px-3 py-1.5 bg-blue-600 text-white rounded-lg flex items-center gap-1 text-xs hover:bg-blue-700 transition">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                        Kirim
                                    </button>
                                </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500">
                        Tidak ada data registrasi
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

{{-- SWEETALERT --}}
<script>
function confirmSend(id) {

    Swal.fire({
        title: 'Kirim ke Dokter?',
        text: 'Pasien akan ditandai siap diperiksa dokter.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, kirim',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280'
    }).then((result) => {

        if (result.isConfirmed) {

            // Disable button biar tidak double click
            const btn = document.querySelector(`#send-form-${id} button`);
            btn.disabled = true;
            btn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin"></i> Mengirim...';

            document.getElementById('send-form-' + id).submit();
        }
    });
}
</script>
@endsection
