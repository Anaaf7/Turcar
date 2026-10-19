@props([
    'label' => null,
    'name',
    'id' => null,
    'rows' => 4,
    'value' => '',
])

@php
    $textareaId = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<div>
    @if ($label)
        <label for="{{ $textareaId }}" class="block text-xs font-display font-bold uppercase tracking-wider text-black-bean-700 mb-1.5">
            {{ $label }}
        </label>
    @endif

    <textarea
        id="{{ $textareaId }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-xl border bg-white text-sm text-black-bean placeholder:text-black-bean-300 px-3.5 py-2.5 transition-all focus:outline-none focus:ring-2 focus:ring-fire-red/20 focus:border-fire-red ' .
                ($hasError ? 'border-fire-red bg-fire-red-50/30' : 'border-black-bean/15 hover:border-black-bean/30')
        ]) }}
    >{{ $slot->isEmpty() ? $value : $slot }}</textarea>

    @error($name)
        <p class="mt-1 text-xs font-medium text-fire-red flex items-center gap-1">
            <x-icon name="alert-circle" class="w-3.5 h-3.5" />
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
