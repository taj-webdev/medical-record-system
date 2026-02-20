@php
    $roleId = session('user.role_id');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Medical Record System')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('medical1.png') }}">

    @vite('resources/css/app.css')

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-100 min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-slate-900 text-slate-200 flex flex-col">

        {{-- LOGO --}}
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-700">
            <img src="{{ asset('medical3.png') }}" class="w-10 h-10 object-contain" alt="Logo">
            <span class="font-semibold text-lg">Medical Record System</span>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-4 space-y-1 text-sm">

            {{-- DASHBOARD (ALL) --}}
            @if($roleId === 1)
                <a href="/dashboard" class="sidebar-link">
                    <i data-lucide="layout-dashboard"></i>
                    Dashboard
                </a>
            @elseif($roleId === 2)
                <a href="/dashboard-doctor" class="sidebar-link">
                    <i data-lucide="layout-dashboard"></i>
                    Dashboard
                </a>
            @elseif($roleId === 3)
                <a href="/dashboard-nurse" class="sidebar-link">
                    <i data-lucide="layout-dashboard"></i>
                    Dashboard
                </a>
            @endif

            {{-- PASIEN --}}
            @if($roleId === 1)
                {{-- ADMIN --}}
                <a href="/pasien" class="sidebar-link">
                    <i data-lucide="users"></i>
                    Pasien
                </a>
            @elseif($roleId === 2)
                {{-- DOCTOR --}}
                <a href="/pasien/doctor" class="sidebar-link">
                    <i data-lucide="users"></i>
                    Pasien
                </a>
            @elseif($roleId === 3)
                {{-- NURSE --}}
                <a href="/pasien/nurse" class="sidebar-link">
                    <i data-lucide="users"></i>
                    Pasien
                </a>
            @endif

            {{-- REGISTRASI & ANTRIAN (ADMIN, NURSE) --}}
            @if(in_array($roleId, [1,3]))
                <a
                    href="{{ $roleId === 1 ? route('registrations.index') : route('registrations.nurse') }}"
                    class="sidebar-link"
                >
                    <i data-lucide="clipboard-list"></i>
                    Registrasi & Antrian
                </a>
            @endif

            {{-- VITAL SIGN (NURSE FULL, DOCTOR READ) --}}
            @if($roleId === 3)
                {{-- NURSE --}}
                <a href="{{ route('registrations.nurse') }}" class="sidebar-link">
                    <i data-lucide="activity"></i>
                    Vital Sign
                </a>
            @elseif($roleId === 2)
                {{-- DOCTOR --}}
                <a href="{{ route('patients.doctor') }}" class="sidebar-link">
                    <i data-lucide="activity"></i>
                    Vital Sign
                </a>
            @endif
            
            {{-- REKAM MEDIS (DOCTOR FULL, ADMIN READ) --}}
            @if(in_array($roleId, [1,2]))
                <a href="{{ route('medical-records.index') }}" class="sidebar-link">
                    <i data-lucide="stethoscope"></i>
                    Rekam Medis
                </a>
            @endif

            {{-- RESEP & OBAT --}}
            @if(in_array($roleId, [1,2]))
                <a href="{{ route('medical-records.index') }}" class="sidebar-link">
                    <i data-lucide="pill"></i>
                    Resep & Obat
                </a>
            @endif
            
            {{-- BILLING (ADMIN ONLY) --}}
            @if($roleId === 1)
                <a href="{{ route('billing.index') }}"
                   class="sidebar-link {{ request()->routeIs('billing.*') ? 'bg-slate-800 text-white' : '' }}">
                    <i data-lucide="receipt"></i>
                    Billing
                </a>
            @endif

            {{-- MASTER DATA (ADMIN ONLY) --}}
            @if($roleId === 1)
                <a href="{{ route('master.index') }}"
                   class="sidebar-link {{ request()->routeIs('master.*') ? 'bg-slate-800 text-white' : '' }}">
                    <i data-lucide="settings"></i>
                    Master Data
                </a>
            @endif
            
        </nav>

        {{-- LOGOUT --}}
        <div class="px-4 py-4 border-t border-slate-700">
            <form method="POST" 
                  action="{{ route('logout') }}" 
                  id="logoutForm">
                @csrf
                <button type="button"
                        onclick="confirmLogout()"
                        class="w-full sidebar-link text-red-400 hover:text-red-300">
                    <i data-lucide="log-out"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">

            {{-- LEFT : WELCOME --}}
            <div class="flex items-center gap-3">
                <span class="text-lg font-semibold text-gray-700">
                    SELAMAT DATANG,
                    <span class="text-blue-600">
                        {{ session('user.name') }}
                    </span>
                    ({{ session('user.role_id') == 1 ? 'Admin' : (session('user.role_id') == 2 ? 'Doctor' : 'Nurse') }})
                </span>

                {{-- WAVE ICON --}}
                <i data-lucide="hand" class="w-6 h-6 text-yellow-500 animate-bounce"></i>
            </div>

            {{-- RIGHT : DATE TIME --}}
            <div class="flex items-center gap-2 text-gray-600">
                <i data-lucide="calendar-clock" class="w-5 h-5"></i>
                <span id="datetime" class="text-sm font-medium"></span>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-white text-center text-sm text-gray-500 py-3 border-t">
            © {{ date('Y') }} Medical Record System. All Rights Reserved
        </footer>
    </div>

    {{-- STYLE --}}
    <style>
        /* =========================
           SIDEBAR LINK
        ========================= */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-link i {
            width: 18px;
            height: 18px;
        }

        .sidebar-link:hover {
            background-color: rgb(30 41 59);
            color: white;
            transform: translateX(4px);
        }

        /* =========================
           GLOBAL ANIMATION
        ========================= */
        .animate-fade-in {
            animation: fadeIn .8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-card {
            animation: fadeUp .6s ease forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    {{-- SCRIPT --}}
    <script>
        lucide.createIcons();

        function updateDateTime() {
            const now = new Date().toLocaleString('id-ID', {
                timeZone: 'Asia/Jakarta',
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            document.getElementById('datetime').innerText = now + ' WIB';
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    <!-- LOGOUT LOADING OVERLAY -->
    <div id="logoutOverlay"
         style="display:none; position:fixed; inset:0; background:rgba(255,255,255,.85); backdrop-filter:blur(6px); align-items:center; justify-content:center; flex-direction:column; z-index:9999;">
        <i data-lucide="heart-pulse"
           style="width:64px;height:64px;color:#dc2626;animation:heartbeat 1.5s infinite;"></i>
        <p style="margin-top:16px;font-weight:500;color:#374151;">
            Sedang memproses logout, mohon tunggu...
        </p>
    </div>

    <style>
    @keyframes heartbeat {
        0% { transform: scale(1); opacity: .7; }
        25% { transform: scale(1.1); opacity: 1; }
        50% { transform: scale(1); }
        75% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: .7; }
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    </script>
    @endif

    @if(session('error'))
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session('error') }}',
        confirmButtonColor: '#ef4444'
    });
    </script>
    @endif
    
    <script>
    function hapus(id) {
        Swal.fire({
            title: 'Yakin Hapus?',
            text: 'Data Pasien Akan Dihapus Permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/pasien/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        })
    }
    </script>

    <script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah anda yakin ingin Logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280'
        }).then((result) => {
            if (result.isConfirmed) {
                const overlay = document.getElementById('logoutOverlay');
                overlay.style.display = "flex";
                document.getElementById('logoutForm').submit();
            }
        });
    }
    </script>
</body>
</html>
