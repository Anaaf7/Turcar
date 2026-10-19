@props([
    'name',
])

<i data-lucide="{{ $name }}" {{ $attributes->merge(['class' => 'inline-block shrink-0']) }}></i>
