@extends('layouts.main')
@section('title','Detail Invoice')

@section('content')
<div class="animate-fade-in">

    {{-- ================= HEADER ================= --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-700 flex items-center gap-2">
            <i data-lucide="file-text" class="w-6 h-6 text-indigo-600"></i>
            Detail Invoice
        </h1>

        <a href="{{ route('billing.print',$invoice->id) }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center gap-2 transition">
            <i data-lucide="printer" class="w-4 h-4"></i>
            Cetak PDF
        </a>
    </div>

    {{-- ================= INFO CARD ================= --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <div class="grid md:grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-gray-500">No Invoice</p>
                <p class="font-semibold text-gray-700">{{ $invoice->invoice_number }}</p>
            </div>

            <div>
                <p class="text-gray-500">Nama Pasien</p>
                <p class="font-semibold text-gray-700">{{ $patient->name }}</p>
            </div>

            <div>
                <p class="text-gray-500">Total Tagihan</p>
                <p class="font-bold text-green-600 text-lg">
                    Rp {{ number_format($invoice->total_amount,0,',','.') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>

                @if($invoice->status == 'paid')
                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Paid
                    </span>

                @elseif($invoice->status == 'unpaid')
                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        Unpaid
                    </span>

                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        Cancelled
                    </span>
                @endif

            </div>

        </div>

    </div>


    {{-- ================= PAYMENT SECTION ================= --}}
    @if($invoice->status == 'unpaid')
    <div class="bg-white rounded-xl shadow p-6 mb-6 border border-yellow-200">

        <h3 class="font-semibold mb-4 flex items-center gap-2 text-gray-700">
            <i data-lucide="credit-card" class="w-5 h-5"></i>
            Proses Pembayaran
        </h3>

        <form method="POST" action="{{ route('billing.pay', $invoice->id) }}">
            @csrf

            <div class="flex flex-col md:flex-row gap-4 items-end">

                <div class="flex-1">
                    <label class="text-xs text-gray-500">Metode Pembayaran</label>
                    <select name="payment_method"
                            required
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Metode --</option>
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Debit">Debit</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>

                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 flex items-center gap-2 transition">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Bayar Sekarang
                </button>

            </div>

        </form>

    </div>
    @endif


    {{-- ================= PAYMENT INFO (IF PAID) ================= --}}
    @if($invoice->status == 'paid' && isset($payment))
    <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">

        <h3 class="font-semibold mb-3 flex items-center gap-2 text-green-700">
            <i data-lucide="badge-check" class="w-5 h-5"></i>
            Pembayaran Berhasil
        </h3>

        <div class="text-sm space-y-1">
            <p><strong>Metode:</strong> {{ $payment->payment_method }}</p>
            <p><strong>Dibayar Pada:</strong> {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') }}</p>
        </div>

    </div>
    @endif


    {{-- ================= TINDAKAN MEDIS ================= --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2 text-gray-700">
            <i data-lucide="activity" class="w-5 h-5 text-indigo-600"></i>
            Tindakan Medis
        </h3>

        @forelse($actions as $a)
            <div class="flex justify-between border-b py-2 text-sm">
                <span>{{ $a->name }}</span>
                <span class="font-semibold">
                    Rp {{ number_format($a->cost,0,',','.') }}
                </span>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Tidak ada tindakan</p>
        @endforelse
    </div>


    {{-- ================= OBAT ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2 text-gray-700">
            <i data-lucide="pill" class="w-5 h-5 text-purple-600"></i>
            Obat
        </h3>

        @forelse($medicines as $m)
            <div class="flex justify-between border-b py-2 text-sm">
                <span>{{ $m->name }} ({{ $m->quantity }}x)</span>
                <span class="font-semibold">
                    Rp {{ number_format($m->price * $m->quantity,0,',','.') }}
                </span>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Tidak ada obat</p>
        @endforelse
    </div>

</div>
@endsection
