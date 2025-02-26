<x-button
    {{ $attributes->merge([
        'class' => 'border-sky-100 dark:border-slate-950 bg-sky-100 dark:bg-slate-700 hover:bg-sky-200 dark:hover:bg-slate-600'
        ])
    }}
>
    {{ $slot }}
</x-button>
