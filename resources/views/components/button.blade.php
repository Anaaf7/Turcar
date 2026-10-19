@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconRight' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-display font-semibold rounded-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';

    $variantClasses = match ($variant) {
        'primary' => 'bg-fire-red hover:bg-fire-red-700 text-white shadow-sm hover:shadow-md focus:ring-fire-red',
        'secondary' => 'bg-black-bean hover:bg-black-bean-800 text-champagne shadow-sm focus:ring-black-bean',
        'champagne' => 'bg-champagne hover:bg-champagne-300 text-black-bean font-bold shadow-sm focus:ring-champagne-500',
        'outline' => 'border border-black-bean/20 bg-white hover:bg-black-bean hover:text-white hover:border-black-bean text-black-bean focus:ring-black-bean',
        'outline-red' => 'border border-fire-red text-fire-red bg-transparent hover:bg-fire-red hover:text-white focus:ring-fire-red',
        'ghost' => 'bg-transparent hover:bg-champagne-100 text-black-bean-800',
        'danger' => 'bg-red-50 hover:bg-fire-red text-fire-red hover:text-white border border-fire-red/20 focus:ring-fire-red',
        default => 'bg-fire-red hover:bg-fire-red-700 text-white focus:ring-fire-red',
    };

    $sizeClasses = match ($size) {
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3.5 py-2 text-xs uppercase tracking-wider',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3.5 text-base',
        default => 'px-5 py-2.5 text-sm',
    };

    $iconSize = match ($size) {
        'xs' => 'w-3.5 h-3.5',
        'sm' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
        default => 'w-4 h-4',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses} {$sizeClasses}"]) }}>
        @if ($icon)
            <x-icon :name="$icon" :class="$iconSize" />
        @endif
        {{ $slot }}
        @if ($iconRight)
            <x-icon :name="$iconRight" :class="$iconSize" />
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses} {$sizeClasses}"]) }}>
        @if ($icon)
            <x-icon :name="$icon" :class="$iconSize" />
        @endif
        {{ $slot }}
        @if ($iconRight)
            <x-icon :name="$iconRight" :class="$iconSize" />
        @endif
    </button>
@endif
