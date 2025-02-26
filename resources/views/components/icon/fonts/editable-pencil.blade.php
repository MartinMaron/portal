@props([
    'value' => false,
])
@if ($value)
    <x-icon.fonts.pencil {{$attributes->merge(['class' => 'text-red-100']) }}></x-icon.fonts.pencil>
@else
    <x-icon.fonts.pencil {{$attributes->merge(['class' => 'text-green-100']) }}></x-icon.fonts.pencil>
@endif
