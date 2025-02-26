<x-button 
    {{ $attributes->merge([
        'class' => 'border-0 bg-sky-100 hover:bg-sky-200 active:bg-sky-200 '
        ]) 
    }}
>
    {{ $slot }}
</x-button>
