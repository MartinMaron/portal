@props([
    'value' => false,
])

@if ($value)
    <i  {{ $attributes->merge(['class' => 'text-green-500 fa-kit fa-regular-envelope-circle-check']) }} ></i>
@else
    <i  {{ $attributes->merge(['class' => 'text-red-500 fa-kit fa-kit fa-regular-envelope-lock']) }} ></i>
@endif


