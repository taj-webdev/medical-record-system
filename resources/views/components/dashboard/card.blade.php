@props([
    'title',
    'icon',
    'color' => 'blue',
    'value',
    'percent' => 0,
])

@php
    $percentValue = is_numeric($percent) ? min(abs($percent), 100) : 0;
@endphp

<div class="bg-white rounded-xl shadow p-5 transition hover:scale-[1.02] animate-card">
    <div class="flex justify-between items-center">

        {{-- LEFT --}}
        <div>
            <p class="text-sm text-gray-500">
                {{ $title }}
            </p>

            <h2 class="text-3xl font-bold mt-1 count-up">
                {{ $value }}
            </h2>

            {{-- PERCENT --}}
            @if($percent > 0)
                <p class="text-xs mt-2 text-green-600 flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                    {{ $percent }}%
                </p>
            @elseif($percent < 0)
                <p class="text-xs mt-2 text-red-600 flex items-center gap-1">
                    <i data-lucide="trending-down" class="w-4 h-4"></i>
                    {{ abs($percent) }}%
                </p>
            @else
                <p class="text-xs mt-2 text-gray-400">
                    Tidak ada perubahan
                </p>
            @endif
        </div>

        {{-- RIGHT (CIRCULAR INDICATOR) --}}
        <div class="relative w-16 h-16">
            <svg class="w-full h-full rotate-[-90deg]">
                <circle
                    cx="32" cy="32" r="28"
                    stroke="#e5e7eb"
                    stroke-width="6"
                    fill="none"
                />
                <circle
                    cx="32" cy="32" r="28"
                    stroke="currentColor"
                    stroke-width="6"
                    class="text-{{ $color }}-500"
                    stroke-dasharray="175"
                    stroke-dashoffset="{{ 175 - (175 * $percentValue / 100) }}"
                    fill="none"
                />
            </svg>

            <i
                data-lucide="{{ $icon }}"
                class="absolute inset-0 m-auto w-6 h-6 text-{{ $color }}-600"
            ></i>
        </div>

    </div>
</div>
