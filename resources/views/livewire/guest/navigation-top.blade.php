


<nav class="rounded-md shadow-md bg-sky-100 border-sky-300">
    <div class="justify-between hidden sm:flex">

        <a class="m-1 ml-4" href="{{ route('guest.home')}}" :active="request()->routeIs('login')">
            <x-jet-application-mark class="block w-auto h-9" />
        </a>
        <!-- Primary Navigation Menu -->
        <div class="items-center justify-start w-full my-1 sm:flex sm:flex-wrap max-w-7xl">
               <!-- Navigation Links -->
               <!-- Dienstleistungen -->
            <x-jet-dropdown align="left" :active="request()->routeIs('user.dashboard')" >
                <x-slot name="trigger">
                        <x-button.navigation class="flex" >
                            <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                                {{ __('DIENSTLEISTUNGEN') }}
                            </span>
                            <i class="mt-1 ml-2 text-md fa fa-chevron-down"></i>
                        </x-button.navigation>
                </x-slot>
                <x-slot name="content">
                    <x-jet-dropdown-link href="{{ route('guest.heizkostenabrechnung') }}">
                    {{ __('Heizkosten') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.betriebskostenabrechnung') }}">
                    {{ __('Betriebskosten') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.energieausweis') }}">
                    {{ __('Energieausweis') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.rauchmelderservice') }}">
                    {{ __('Rauchmelderservice') }}
                    </x-jet-dropdown-link>
                </x-slot>
            </x-jet-dropdown>
             <!-- Geräteservice -->
            <x-jet-dropdown align="left" href="{{ route('user.dashboard') }}" :active="request()->routeIs('user.dashboard')" >
                <x-slot name="trigger">
                    <x-button.navigation class="flex">
                        <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                            {{ __('GERÄTESERVICE') }}
                        </span>
                        <i class="mt-1 ml-2 text-md fa fa-chevron-down"></i>
                    </x-button.navigation>
                </x-slot>

                <x-slot name="content">
                    <x-jet-dropdown-link href="{{ route('guest.heizkostenverteiler') }}">
                        {{ __('Heizkostenverteiler') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.waermezaehler') }}">
                        {{ __('Wäremzähler') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.wasserzaehler') }}">
                        {{ __('Wasserzähler') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.rauchmelder') }}">
                        {{ __('Rauchmelder') }}
                    </x-jet-dropdown-link>
                </x-slot>
            </x-jet-dropdown>
            <x-button.navigation class="flex" :active="request()->routeIs('guest.messdienstwechsel')">
                <a href="{{route('guest.messdienstwechsel')}}">
                    <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                        {{ __('MESSDIENSTWECHSEL') }}
                    </span>
                </a>
            </x-button.navigation>
            <x-button.navigation class="flex" :active="request()->routeIs('guest.kontakt')">
                <a href="{{route('guest.kontakt')}}">
                    <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                        {{ __('KONTAKT') }}
                    </span>
                </a>
            </x-button.navigation>
        </div>
        <div class="items-center justify-end px-3 my-1 sm:flex sm:flex-wrap max-w-7xl">
            <x-button.navigation>
                <a href="{{route('login')}}">
                    <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                        {{ __('NUTZERBEREICH') }}
                    </span>
                </a>
            </x-button.navigation>
        </div>
    </div>
    @if(Route::current()->getName() != 'login')
        <div class="flex items-center justify-between sm:hidden">

            <!-- Navigation -->
             <!-- Geräteservice -->
             <x-jet-dropdown align="left" href="{{ route('user.dashboard') }}" :active="request()->routeIs('user.dashboard')" >
                <x-slot name="trigger">
                    <i class="mt-1 ml-2 text-2xl transition duration-150 fa-solid fa-bars text-sky-900 opacity-90 group-hover:opacity-100 ease"></i>
                </x-slot>

                <x-slot name="content">
                    <!-- Dienstleistungen -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Diensleistungen') }}
                    </div>
                    <x-jet-dropdown-link href="{{ route('guest.heizkostenabrechnung') }}">
                    {{ __('Heizkosten') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.betriebskostenabrechnung') }}">
                    {{ __('Betriebskosten') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.energieausweis') }}">
                    {{ __('Energieausweis') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.rauchmelderservice') }}">
                    {{ __('Rauchmelderservice') }}
                    </x-jet-dropdown-link>

                    <!-- Geräteservice -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Geräteservice') }}
                    </div>
                    <x-jet-dropdown-link href="{{ route('guest.heizkostenverteiler') }}">
                        {{ __('Heizkostenverteiler') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.waermezaehler') }}">
                        {{ __('Wäremzähler') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.wasserzaehler') }}">
                        {{ __('Wasserzähler') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.rauchmelder') }}">
                        {{ __('Rauchmelder') }}
                    </x-jet-dropdown-link>

                    <!-- sonstiges -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('...') }}
                    </div>
                    <x-jet-dropdown-link href="{{ route('guest.heizkostenverteiler') }}">
                        {{ __('Messdienstwechsel') }}
                    </x-jet-dropdown-link>
                    <x-jet-dropdown-link href="{{ route('guest.waermezaehler') }}">
                        {{ __('Kontakt') }}
                    </x-jet-dropdown-link>

                </x-slot>
            </x-jet-dropdown>

            {{-- <!-- Login -->
            <a class="font-semibold text-right text-md text-sky-900 opacity-90" href="{{ route('login') }}" :active="request()->routeIs('login')">
                {{ __('LogIn -> Nutzerbereich') }}
            </a> --}}

            <x-button.navigation class="flex">
                <a href="{{route('login')}}">
                    <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                        {{ __('Nutzerbereich') }}
                    </span>
                </a>
            </x-button.navigation>


        </div>
    @endif

</nav>

