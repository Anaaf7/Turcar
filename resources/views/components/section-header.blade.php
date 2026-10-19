@props([
    'subtitle' => null,
    'title',
    'description' => null,
    'actionText' => null,
    'actionHref' => null,
    'align' => 'between',
])

<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8']) }}>
    <div>
        @if ($subtitle)
            <span class="inline-block text-xs font-display font-bold uppercase tracking-widest text-fire-red mb-1.5">
                {{ $subtitle }}
            </span>
        @endif
        <h2 class="text-2xl md:text-3xl font-display font-bold text-black-bean tracking-tight">
            {{ $title }}
        </h2>
        @if ($description)
            <p class="text-sm text-black-bean-600 mt-1.5 max-w-2xl">
                {{ $description }}
            </p>
        @endif
    </div>

    @if ($actionText && $actionHref)
        <a href="{{ $actionHref }}" class="inline-flex items-center gap-1.5 text-xs md:text-sm font-display font-bold uppercase tracking-wider text-fire-red hover:text-fire-red-800 transition-colors group">
            <span>{{ $actionText }}</span>
            <x-icon name="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1" />
        </a>
    @elseif (isset($actions))
        <div class="flex items-center gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
