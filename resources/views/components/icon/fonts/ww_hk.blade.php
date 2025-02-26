@props([
    'hk' => true,
])

@if ($hk)
    <x-icon.fonts.heizung {{ $attributes->merge(['class' => 'text-green-600 dark:text-green-500']) }}></x-icon.fonts.heizung>
@else
    <x-icon.fonts.warmwasser {{ $attributes->merge(['class' => 'text-red-800 dark:text-red-400']) }}></x-icon.fonts.warmwasser>
@endif
