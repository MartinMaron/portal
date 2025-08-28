<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:bg-slate-700">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

    <!-- Styles -->
    @livewireStyles
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/fec4df1c10.js" crossorigin="anonymous"></script>
</head>

<body class="font-sans antialiased">
<livewire:toasts/>

{{-- <x-jet-banner /> --}}
{{-- <input type="text" id="datepicker"> --}}

<div class="bg-white dark:bg-slate-700 w-full">
    <div class="md:py-2 max-w-7xl sm:px-6 lg:px-8 mx-auto">
        <livewire:user.navigation-top/>
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
@livewireScriptConfig
@include('cookie-consent::index')

</body>
</html>
