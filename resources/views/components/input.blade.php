@props([
    'label' => null,
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'icon' => null,
    'hint' => null,
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<div>
    @if ($label)
        <label for="{{ $inputId }}" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700 mb-1.5">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3.5 flex items-center text-black-bean-400">
                <x-icon :name="$icon" class="w-4 h-4 text-fire-red" />
            </div>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border bg-white text-sm text-black-bean placeholder:text-black-bean-300 py-2.5 transition-all focus:outline-none focus:ring-2 focus:ring-fire-red/20 focus:border-fire-red ' .
                    ($icon ? 'pl-10 pr-3.5 ' : 'px-3.5 ') .
                    ($hasError ? 'border-fire-red bg-fire-red-50/30' : 'border-black-bean/15 hover:border-black-bean/30')
            ]) }}
        >
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1 text-[11px] text-black-bean-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs font-medium text-fire-red flex items-center gap-1">
            <x-icon name="alert-circle" class="w-3.5 h-3.5" />
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
