<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        /* ================= HEADER ================= */
        .header {
            width: 100%;
            margin-bottom: 10px;
        }

        .header-table {
            width: 100%;
        }

        .logo {
            width: 70px;
        }

        .title-area {
            text-align: center;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .header-line {
            border-bottom: 2px solid #000;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        /* ================= TABLE ================= */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
        }

        /* ================= WATERMARK ================= */
        .watermark {
            position: fixed;
            top: 40%;
            left: 15%;
            width: 70%;
            text-align: center;
            transform: rotate(-35deg);
            font-size: 90px;
            color: rgba(0, 128, 0, 0.15);
            font-weight: bold;
            z-index: -1;
        }

        /* ================= FOOTER ================= */
        .footer-line {
            border-top: 2px solid #000;
            position: fixed;
            bottom: 40px;
            width: 100%;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            text-align: right;
        }

    </style>
</head>

<body>

{{-- WATERMARK --}}
@if($invoice->status == 'paid')
    <div class="watermark">PAID</div>
@endif

{{-- ================= HEADER ================= --}}
<div class="header">

    <table class="header-table">
        <tr>
            <td width="20%">
                <img src="{{ public_path('medical3.png') }}" class="logo">
            </td>
            <td width="60%" class="title-area">
                <div class="title">Medical Record System</div>
                <div>Invoice : {{ $invoice->invoice_number }}</div>
            </td>
            <td width="20%"></td>
        </tr>
    </table>

    <div class="header-line"></div>

</div>

{{-- ================= PATIENT INFO ================= --}}
<p>
<strong>Nama Pasien:</strong> {{ $patient->name }} <br>
<strong>Tanggal Invoice:</strong>
{{ \Carbon\Carbon::parse($invoice->created_at)
    ->locale('id')
    ->translatedFormat('d F Y') }}
</p>

{{-- ================= TINDAKAN ================= --}}
<h4>Tindakan Medis</h4>
<table>
    <thead>
        <tr>
            <th>Nama Tindakan</th>
            <th class="text-right">Biaya</th>
        </tr>
    </thead>
    <tbody>
        @foreach($actions as $a)
        <tr>
            <td>{{ $a->name }}</td>
            <td class="text-right">
                Rp {{ number_format($a->cost,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- ================= OBAT ================= --}}
<h4>Obat</h4>
<table>
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Qty</th>
            <th class="text-right">Harga</th>
            <th class="text-right">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($medicines as $m)
        <tr>
            <td>{{ $m->name }}</td>
            <td>{{ $m->quantity }}</td>
            <td class="text-right">
                Rp {{ number_format($m->price,0,',','.') }}
            </td>
            <td class="text-right">
                Rp {{ number_format($m->quantity * $m->price,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

{{-- ================= TOTAL ================= --}}
<table>
    <tr>
        <td class="total">Total</td>
        <td class="text-right total">
            Rp {{ number_format($invoice->total_amount,0,',','.') }}
        </td>
    </tr>
</table>

<p style="margin-top:30px; text-align:center;">
    Terima kasih atas kunjungan Anda
</p>

{{-- ================= FOOTER ================= --}}
<div class="footer-line"></div>

<div class="footer">
    @php
        $now = \Carbon\Carbon::now('Asia/Jakarta');
    @endphp
    Dicetak Pada :
    {{ $now->locale('id')->translatedFormat('l, d F Y H:i') }} WIB
</div>

</body>
</html>
