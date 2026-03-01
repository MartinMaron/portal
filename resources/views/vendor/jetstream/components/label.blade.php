@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:bg-slate-900 dark:text-gray-200']) }}>
    {{ $value ?? $slot }}
</label>
