<x-button 
    {{ $attributes->merge([
        'class' => 'border-0 bg-sky-100 dark:bg-slate-900 hover:bg-sky-200 dark:hover:bg-slate-800 active:bg-sky-200 dark:active:bg-slate-700 text-sky-900 dark:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-300 focus:ring-offset-2 focus:ring-offset-sky-100 dark:focus:ring-offset-slate-900'
        ]) 
    }}
>
    {{ $slot }}
</x-button>
