<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:bg-slate-700">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="dns-prefetch" href="//fonts.gstatic.com">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/fec4df1c10.js" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased">
        <livewire:toasts />

        {{-- <x-jet-banner /> --}}
        {{-- <input type="text" id="datepicker"> --}}

        <div class="bg-white dark:bg-slate-700 w-full">
            <div class="md:py-2 max-w-7xl sm:px-6 lg:px-8 mx-auto">
                <livewire:user.navigation-top />
            </div>
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-slate-700">
                    <div class="py-1 md:py-1 max-w-7xl sm:px-6 lg:px-8 mx-auto">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl sm:px-6 lg:px-8 mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
