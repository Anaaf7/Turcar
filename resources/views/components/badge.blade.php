@props([
    'status' => null,
    'variant' => 'default',
])

@php
    $resolvedVariant = $status ? strtolower($status) : $variant;

    $classes = match ($resolvedVariant) {
        'disponivel', 'success' => 'bg-emerald-500/15 text-emerald-800 border-emerald-500/30',
        'reservado', 'warning' => 'bg-champagne-200 text-black-bean border-champagne-400',
        'vendido', 'danger' => 'bg-fire-red/15 text-fire-red-800 border-fire-red/30',
        'dark', 'black-bean' => 'bg-black-bean text-champagne border-black-bean-700',
        'fire-red', 'primary' => 'bg-fire-red text-white border-fire-red-700',
        default => 'bg-champagne-100 text-black-bean-800 border-champagne-300',
    };

    $label = match ($resolvedVariant) {
        'disponivel' => 'Disponível',
        'reservado' => 'Reservado',
        'vendido' => 'Vendido',
        default => null,
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border tracking-wide {$classes}"]) }}>
    @if ($status)
        <span class="w-1.5 h-1.5 rounded-full {{ $resolvedVariant === 'disponivel' ? 'bg-emerald-600' : ($resolvedVariant === 'reservado' ? 'bg-amber-600' : 'bg-fire-red') }}"></span>
    @endif
    {{ $slot->isEmpty() ? $label : $slot }}
</span>
