
<div class="bg-sky-100 dark:bg-slate-500 rounded-md">
    <!-- Small Screen -->
    <nav class="sm:hidden my-1 border-b border-gray-100 dark:border-gray-600 rounded-md flex justify-between pt-1 pb-1">

        <!-- Dropdown (hamburger) rechts-->
        <div class="items-center ml-2">
            <x-jet-dropdown align="left" href="{{ route('user.dashboard') }}" :active="request()->routeIs('user.dashboard')" >
                <x-slot name="trigger">
                    <i class="mt-1 text-2xl transition duration-150 fa-solid fa-bars text-sky-900 opacity-90 group-hover:opacity-100 ease"></i>
                </x-slot>

                <x-slot name="content">

                    <!-- sonstiges -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Menu') }}
                    </div>
                    <x-jet-dropdown-link href="{{ route('guest.home') }}">
                        {{ __('Startseite') }}
                    </x-jet-dropdown-link>
                    @if (auth()->user()->isMieter)
                        <x-jet-dropdown-link href="{{ route('user.verbrauchsinfos') }}">
                            {{ __('Verbraucherinformationen') }}
                        </x-jet-dropdown-link>
                    @endif
                    
                    <x-jet-dropdown-link href="{{ route('user.realestates') }}">
                        {{ __('Liegenschaften') }}
                    </x-jet-dropdown-link>

                </x-slot>
            </x-jet-dropdown>
        </div>

        <!-- Dropdown (Kundendaten) links-->
        <div class="items-end">
            <div class="relative pr-2">
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 dark:text-slate-200 transition border border-transparent rounded-md bg-sky-50 dark:bg-slate-800 dark:hover:text-slate-200 hover:text-gray-700 focus:outline-none">
                                {{ Auth::user()->name }}

                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Kontodaten bearbeiten') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Kundenkonto') }}
                        </x-jet-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <!-- Logout -->
                        <div class="hidden md:block">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Ausloggen') }}
                                </x-jet-dropdown-link>
                            </form>
                        </div>
                        <div class="md:hidden">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <x-jet-dropdown-link href="{{ route('login') }}"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Ausloggen') }}
                                </x-jet-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-jet-dropdown>
            </div>
        </div>
    </nav>


 <!-- Big Screen -->

    <nav class="hidden sm:block">
        <div class="flex justify-between sm:justify-items-start sm:max-w-full bg-sky-100 dark:bg-slate-500 rounded-md px-4 py-1">
            <div class="flex items-center">
                <a href="{{ route('guest.home')}}">
                    <x-jet-application-mark class="block w-auto h-10" />
                </a>
                @if (Auth::user()->isUser)
                    <!-- Nutzereinheiten -->
                    <div class="flex items-center ml-2">
                        <div class="flex justify-end space-x-8 md:-my-px md:ml-10 md:flex">
                        <x-jet-nav-link href="{{ route('user.realestates') }}" :active="request()->routeIs('login')">
                            <span class="sm:text-lg font-bold dark:text-slate-950">
                                LIEGENSCHAFTEN
                            </span>
                        </x-jet-nav-link>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->isMieter)
                <div class="hidden md:visible md:flex md:items-center md:ml-6">
                    <!-- Nutzereinheiten -->
                    <div class="flex justify-end space-x-8 md:-my-px md:ml-10 md:flex">
                        <x-jet-nav-link href="{{ route('user.verbrauchsinfos') }}" :active="request()->routeIs('login')">
                            <span class="sm:text-lg">
                                Verbraucherinformationen
                            </span>
                        </x-jet-nav-link>
                    </div>
                </div>
                @endif
            </div>
            <div class="flex items-center">
                <!-- Settings Dropdown -->
                <x-jet-dropdown class="">
                    <x-slot name="trigger">
                        <span class="flex align-middle rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-3 text-sm font-medium leading-4 text-gray-500 bg-sky-50 dark:bg-slate-800 dark:text-gray-50 dark:hover:text-gray-100 dark:hover:font-semibold dark:hover:bg-slate-950 transition border border-transparent rounded-md  hover:text-gray-700 focus:outline-none">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400 dark:bg-slate-800 dark:text-slate-100 dark:font-semibold">
                            {{ __('Kontodaten bearbeiten') }}
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Kundenkonto') }}
                        </x-jet-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <!-- Logout -->
                        <div class="hidden md:block">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Ausloggen') }}
                                </x-jet-dropdown-link>
                            </form>
                        </div>
                        <div class="md:hidden">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <x-jet-dropdown-link href="{{ route('login') }}"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Ausloggen') }}
                                </x-jet-dropdown-link>
                            </form>
                        </div>

                    </x-slot>
                </x-jet-dropdown>
            </div>
        </div>
    </nav>
</div>







</div>
