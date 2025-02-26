@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-sky-300 focus:ring focus:ring-sky-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
