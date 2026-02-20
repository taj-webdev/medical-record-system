<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Rekam Medis</title>

    <style>
        @page {
            margin: 120px 40px 80px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            position: relative;
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

        /* ================= HEADER ================= */
        header {
            position: fixed;
            top: -90px;
            left: 0;
            right: 0;
            height: 70px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 70px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        /* ================= TABLE ================= */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #444;
            padding: 6px;
        }

        table.data-table th {
            background: #f2f2f2;
            text-align: center;
        }

        table.data-table td {
            text-align: center;
        }

        /* ================= FOOTER ================= */
        footer {
            position: fixed;
            bottom: -50px;
            right: 0;
            text-align: right;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>

    {{-- WATERMARK --}}
    <div class="watermark">
        CONFIDENTIAL
    </div>

    {{-- HEADER --}}
    <header>
        <table class="header-table">
            <tr>
                <td width="20%">
                    <img src="{{ public_path('medical3.png') }}" class="logo">
                </td>
                <td width="80%" class="title">
                    DAFTAR REKAM MEDIS PASIEN
                </td>
            </tr>
        </table>
        <hr>
    </header>

    {{-- FOOTER --}}
    <footer>
        Di Cetak Pada :
        {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }} WIB
    </footer>

    {{-- CONTENT --}}
    <main>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No RM</th>
                    <th>Nama Pasien</th>
                    <th>Doctor</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $index => $d)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $d->medical_record_number }}</td>
                    <td>{{ $d->patient_name }}</td>
                    <td>{{ $d->doctor_name ?? '-' }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($d->registration_date)
                            ->timezone('Asia/Jakarta')
                            ->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>
</html>
