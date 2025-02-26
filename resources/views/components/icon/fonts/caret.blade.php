@props([
    'direction' => '',
])

@if ($direction == 'r')
    <x-icon.fonts.check></x-icon.fonts.check>
@else
    <x-icon.fonts.xmark></x-icon.fonts.xmark>
@endif