@props([
    'icon' => 'shield-check',
    'title',
    'description',
])

<div class="flex items-start gap-4 px-4 py-3">
    <div class="w-12 h-12 rounded-xl bg-champagne-100 border border-champagne-300 flex items-center justify-center text-fire-red shrink-0 shadow-xs">
        <x-icon :name="$icon" class="w-6 h-6" />
    </div>
    <div>
        <h3 class="font-display font-bold text-sm text-black-bean">{{ $title }}</h3>
        <p class="text-xs text-black-bean-600 leading-relaxed mt-0.5">{{ $description }}</p>
    </div>
</div>
