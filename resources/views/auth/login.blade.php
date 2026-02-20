@extends('layouts.app')

@section('title', 'Login | Medical Record System')

@section('content')

{{-- Lucide --}}
<script src="https://unpkg.com/lucide@latest"></script>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes heartBeat {
        0% { transform: scale(1); opacity: .7; }
        25% { transform: scale(1.1); opacity: 1; }
        50% { transform: scale(1); }
        75% { transform: scale(1.1); }
        100% { transform: scale(1); opacity: .7; }
    }

    .fade-in {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .login-overlay {
        position: fixed;
        inset: 0;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 9999;
    }

    .heart-loader {
        animation: heartBeat 1.5s infinite;
        color: #2563eb;
    }
</style>

<div class="min-h-screen flex bg-gray-100">

    {{-- ================= OVERLAY LOADING ================= --}}
    <div id="loginOverlay" class="login-overlay">
        <i data-lucide="heart-pulse" class="w-16 h-16 heart-loader"></i>
        <p class="mt-4 text-gray-700 font-medium">
            Sedang memproses login, mohon tunggu...
        </p>
    </div>

    {{-- LEFT BACKGROUND --}}
    <div class="hidden lg:flex w-1/2 relative">
        <img 
            src="{{ asset('medical2.png') }}" 
            class="absolute inset-0 w-full h-full object-cover"
            alt="Medical Background"
        >
        <div class="absolute inset-0 bg-blue-900/50"></div>

        <div class="relative z-10 flex flex-col justify-center px-16 text-white fade-in">
            <h1 class="text-4xl font-bold mb-4 leading-tight">
                Medical Record System
            </h1>
            <p class="text-lg opacity-90">
                Enterprise-grade healthcare management system <br>
                Secure • Reliable • Scalable
            </p>
        </div>
    </div>

    {{-- RIGHT LOGIN FORM --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8 fade-in">

            {{-- LOGO --}}
            <div class="flex justify-center mb-6">
                <img 
                    src="{{ asset('medical4.png') }}" 
                    alt="Logo"
                    class="w-20 h-20 object-contain"
                >
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
                Welcome Back
            </h2>
            <p class="text-sm text-center text-gray-500 mb-6">
                Please login to continue
            </p>

            @error('login_error')
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    {{ $message }}
                </div>
            @enderror

            <form method="POST" id="loginForm" class="space-y-4">
                @csrf

                {{-- USERNAME --}}
                <div>
                    <label class="text-sm text-gray-600">Username</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input 
                            type="text" 
                            name="username"
                            required
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter your username"
                        >
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input 
                            type="password" 
                            name="password"
                            required
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter your password"
                        >
                    </div>
                </div>

                {{-- BUTTON --}}
                <button 
                    id="loginBtn"
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2"
                >
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Login
                </button>
            </form>

            <p class="text-sm text-center text-gray-500 mt-6">
                Belum punya akun?
                <a href="/register" class="text-blue-600 hover:underline font-medium">
                    Register
                </a>
            </p>

        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    const form = document.getElementById('loginForm');
    const overlay = document.getElementById('loginOverlay');
    const button = document.getElementById('loginBtn');

    form.addEventListener('submit', function() {
        overlay.style.display = "flex";
        button.disabled = true;
    });

    @if(session('login_success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Login',
            text: 'Selamat Datang Kembali, {{ session("login_name") }} 😄🙏🏻',
            timer: 2200,
            showConfirmButton: false
        });
    @endif
</script>
    
    @if(session('logout_success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Logout',
        text: 'Sampai jumpa kembali {{ session('logout_name') }} 😄👋🏻',
        timer: 2500,
        showConfirmButton: false
    });
    </script>
    @endif
@endsection
