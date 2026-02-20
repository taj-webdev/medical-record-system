@extends('layouts.main')
@section('title', 'Dashboard Admin')

@section('content')
<div class="animate-fade-in">

    {{-- ================= CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <x-dashboard.card
            title="Pasien"
            icon="users"
            color="blue"
            :value="$totalPatients"
            :percent="0"
        />

        <x-dashboard.card
            title="Registrasi Hari Ini"
            icon="clipboard-list"
            color="cyan"
            :value="$registrationsToday"
            :percent="$percentRegistrations"
        />

        <x-dashboard.card
            title="Antrian Menunggu"
            icon="activity"
            color="orange"
            :value="$waitingQueue"
            :percent="0"
        />

        <x-dashboard.card
            title="Rekam Medis"
            icon="stethoscope"
            color="purple"
            :value="$medicalRecordsToday"
            :percent="$percentMedical"
        />

        <x-dashboard.card
            title="Invoice"
            icon="receipt"
            color="green"
            :value="$invoicesToday"
            :percent="$percentInvoices"
        />

        <x-dashboard.card
            title="Pendapatan"
            icon="wallet"
            color="emerald"
            :value="'Rp ' . number_format($revenueToday, 0, ',', '.')"
            :percent="$percentRevenue"
        />

    </div>

    {{-- ================= CHART ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold mb-4">
            Aktivitas 7 Hari Terakhir
        </h3>
        <canvas id="lineChart" height="100"></canvas>
    </div>

</div>
@endsection

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = @json($days);

    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Registrasi',
                    data: @json($registrationChart),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,.1)',
                    tension: .4,
                    fill: true
                },
                {
                    label: 'Pendapatan',
                    data: @json($revenueChart),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,.1)',
                    tension: .4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
