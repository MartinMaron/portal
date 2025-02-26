<x-button
    {{ $attributes->merge([
        'class' => 'bg-sky-100 hover:bg-sky-500 active:bg-sky-700 border-sky-600'
        ])
    }}
>
    {{ $slot }}
</x-button>
