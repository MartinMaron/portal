<x-button
    {{ $attributes->merge([
        'class' => 'bg-sky-600 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-800 hover:bg-sky-500 dark:hover:bg-slate-700 active:bg-sky-700 dark:active:bg-slate-500 border-sky-600'
        ])
    }}
>
    {{ $slot }}
</x-button>
