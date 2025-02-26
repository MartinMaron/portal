<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        @livewireStyles

        <!-- Scripts -->
        @toastScripts
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/fec4df1c10.js" crossorigin="anonymous"></script>
        
    </head>
    <body class="font-sans antialiased">
        {{-- <x-jet-banner /> --}}
        <livewire:toasts />

        <div class="bg-white">
            
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <livewire:guest.navigation-top />
            </div>
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <div class="bg-sky-200 opacity-75 block sm:flex sm:justify-center sm:items-center">
                <div class="px-10 opacity-100">
                    <img loading="lazy" class="align-right" src="https://www.e-neko.de/wp-content/uploads/2019/09/eneko-logo-gross-300x107.png" alt="" srcset="https://www.e-neko.de/wp-content/uploads/2019/09/eneko-logo-gross-300x107.png 300w, https://www.e-neko.de/wp-content/uploads/2019/09/eneko-logo-gross.png 466w" sizes="(max-width: 300px) 100vw, 300px" width="300" height="107">
                </div>
                <div class="border-l-2 border-sky-800">
                    <div class="pl-10 opacity-100"><div class=""><span class="text-sky-600">eneko GmbH</span><br>Ansprechpartner: Christof Jaskula<br>Hans-Willy-Mertens Str. 2<br>50858 Köln<br>Tel.: +49 (0)2234 9444320<br>Fax: +49 (0)2234 9444321<br>info@e-neko.de</div></div>
                </div>
            </div>
            
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
