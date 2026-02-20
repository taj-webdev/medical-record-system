@extends('layouts.app')

@section('title', 'Register | Medical Record System')

@section('content')

<script src="https://unpkg.com/lucide@latest"></script>
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

    .register-overlay {
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
        color: #16a34a;
    }
</style>

<div class="min-h-screen flex bg-gray-100">

    {{-- ===== LOADING OVERLAY ===== --}}
    <div id="registerOverlay" class="register-overlay">
        <i data-lucide="heart-pulse" class="w-16 h-16 heart-loader"></i>
        <p class="mt-4 text-gray-700 font-medium">
            Sedang memproses register, mohon tunggu...
        </p>
    </div>

    {{-- LEFT SIDE --}}
    <div class="hidden lg:flex w-1/2 relative">
        <img 
            src="{{ asset('medical2.png') }}" 
            class="absolute inset-0 w-full h-full object-cover"
            alt="Medical Background"
        >
        <div class="absolute inset-0 bg-blue-900/50"></div>

        <div class="relative z-10 flex flex-col justify-center px-16 text-white fade-in">
            <h1 class="text-4xl font-bold mb-4 leading-tight">
                Join Medical Record System
            </h1>
            <p class="text-lg opacity-90">
                Create your account and start managing <br>
                healthcare data securely and efficiently
            </p>
        </div>
    </div>

    {{-- RIGHT FORM --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8 fade-in">

            {{-- LOGO --}}
            <div class="flex justify-center mb-6">
                <img src="{{ asset('medical4.png') }}" 
                     class="w-20 h-20 object-contain"
                     alt="Logo">
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
                Create Account
            </h2>
            <p class="text-sm text-center text-gray-500 mb-6">
                Fill in the form to register
            </p>

            {{-- VALIDATION --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" id="registerForm" class="space-y-4">
                @csrf

                {{-- NAME --}}
                <div>
                    <label class="text-sm text-gray-600">Nama Lengkap</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i data-lucide="id-card" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="name" required
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                               placeholder="Nama lengkap">
                    </div>
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input type="email" name="email"
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                               placeholder="Email (optional)">
                    </div>
                </div>

                {{-- USERNAME --}}
                <div>
                    <label class="text-sm text-gray-600">Username</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="username" required
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                               placeholder="Username">
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                               placeholder="Password">
                    </div>
                </div>

                {{-- ROLE --}}
                <div>
                    <label class="text-sm text-gray-600">Role</label>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <i data-lucide="shield" class="w-4 h-4"></i>
                        </span>
                        <select name="role_id" required
                                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- BUTTON --}}
                <button id="registerBtn" type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    Register
                </button>
            </form>

            <p class="text-sm text-center text-gray-500 mt-6">
                Sudah punya akun?
                <a href="/login" class="text-blue-600 hover:underline font-medium">
                    Login
                </a>
            </p>

        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    const form = document.getElementById('registerForm');
    const overlay = document.getElementById('registerOverlay');
    const button = document.getElementById('registerBtn');

    form.addEventListener('submit', function() {
        overlay.style.display = "flex";
        button.disabled = true;
    });

    @if(session('register_success'))
        Swal.fire({
            icon: 'success',
            title: 'Register Berhasil',
            text: 'Silahkan Login 😄🙏🏻',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection
