@extends('layouts.main')
@section('title','Billing & Invoice')

@section('content')
<div class="animate-fade-in">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700 flex items-center gap-2">
            <i data-lucide="receipt" class="w-6 h-6 text-indigo-600"></i>
            Billing & Invoice
        </h1>
    </div>

    {{-- SEARCH --}}
    <form method="GET" class="mb-6">
        <div class="flex gap-2">
            <input type="text"
                   name="search"
                   value="{{ $search ?? '' }}"
                   placeholder="Cari Nama / No Invoice..."
                   class="border rounded-lg px-3 py-2 w-64 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-1 text-sm">
                <i data-lucide="search" class="w-4 h-4"></i>
                Cari
            </button>
        </div>
    </form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="p-3 text-center">No Invoice</th>
                    <th class="p-3 text-center">Pasien</th>
                    <th class="p-3 text-center">Total</th>
                    <th class="p-3 text-center">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($invoices as $inv)
                <tr class="hover:bg-gray-50 transition">

                    <td class="p-3 font-semibold text-center text-gray-700">
                        {{ $inv->invoice_number }}
                    </td>

                    <td class="p-3 text-center text-gray-600">
                        {{ $inv->patient_name }}
                    </td>

                    <td class="p-3 font-bold text-center text-green-600">
                        Rp {{ number_format($inv->total_amount,0,',','.') }}
                    </td>

                    {{-- STATUS BADGE UPGRADE --}}
                    <td class="p-3 text-center">
                        @if($inv->status == 'paid')
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                <i data-lucide="check-circle" class="w-3 h-3"></i>
                                Paid
                            </span>

                        @elseif($inv->status == 'unpaid')
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                Unpaid
                            </span>

                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                <i data-lucide="x-circle" class="w-3 h-3"></i>
                                Cancelled
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="p-3 text-center">
                        <a href="{{ route('billing.show',$inv->id) }}"
                           class="inline-flex items-center gap-1 bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 text-xs transition">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            Detail
                        </a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-400">
                        Tidak ada data invoice
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $invoices->links() }}
    </div>

</div>
@endsection
