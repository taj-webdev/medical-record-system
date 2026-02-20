@extends('layouts.main')
@section('title', 'Dashboard Nurse')

@section('content')
<div class="animate-fade-in">

    {{-- ================= CARDS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        <x-dashboard.card
            title="Registrasi Hari Ini"
            icon="clipboard-list"
            color="blue"
            :value="$registrationsToday"
            :percent="$percentRegistrations"
        />

        <x-dashboard.card
            title="Antrian Menunggu"
            icon="clock"
            color="orange"
            :value="$waitingToday"
            :percent="$percentWaiting"
        />

        <x-dashboard.card
            title="Vital Sign Belum Input"
            icon="activity"
            color="rose"
            :value="$vitalPendingToday"
            :percent="$percentVitalPending"
        />

        <x-dashboard.card
            title="Vital Sign Selesai"
            icon="check-circle"
            color="green"
            :value="$vitalDoneToday"
            :percent="$percentVitalDone"
        />

        <x-dashboard.card
            title="Siap ke Dokter"
            icon="stethoscope"
            color="purple"
            :value="$readyDoctorToday"
            :percent="$percentReadyDoctor"
        />

    </div>

    {{-- ================= CHART ================= --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold mb-4">
            Aktivitas Operasional (7 Hari Terakhir)
        </h3>
        <canvas id="nurseChart" height="100"></canvas>
    </div>

</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('nurseChart'), {
        type: 'line',
        data: {
            labels: @json($days),
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
                    label: 'Vital Sign',
                    data: @json($vitalChart),
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,.1)',
                    tension: .4,
                    fill: true
                },
                {
                    label: 'Antrian',
                    data: @json($waitingChart),
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249,115,22,.1)',
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
