@extends('layouts.main')
@section('title', 'Dashboard Doctor')

@section('content')
<div class="animate-fade-in">

    {{-- ================= CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <x-dashboard.card
            title="Pasien Hari Ini"
            icon="users"
            color="blue"
            :value="$patientsToday"
            :percent="$percentPatients"
        />

        <x-dashboard.card
            title="Pasien Menunggu"
            icon="clock"
            color="orange"
            :value="$waitingToday"
            :percent="$percentWaiting"
        />

        <x-dashboard.card
            title="Rekam Medis Hari Ini"
            icon="stethoscope"
            color="purple"
            :value="$medicalToday"
            :percent="$percentMedical"
        />

        <x-dashboard.card
            title="Resep Hari Ini"
            icon="pill"
            color="green"
            :value="$prescriptionToday"
            :percent="$percentPrescription"
        />

        <x-dashboard.card
            title="Vital Sign Tersedia"
            icon="activity"
            color="cyan"
            :value="$vitalToday"
            :percent="$percentVital"
        />

    </div>

    {{-- ================= CHART ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold mb-4">
            Aktivitas Klinik Saya (7 Hari Terakhir)
        </h3>
        <canvas id="doctorChart" height="100"></canvas>
    </div>

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('doctorChart'), {
        type: 'line',
        data: {
            labels: @json($days),
            datasets: [
                {
                    label: 'Pasien',
                    data: @json($patientChart),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,.1)',
                    tension: .4,
                    fill: true
                },
                {
                    label: 'Rekam Medis',
                    data: @json($medicalChart),
                    borderColor: '#a855f7',
                    backgroundColor: 'rgba(168,85,247,.1)',
                    tension: .4,
                    fill: true
                }
            ]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
