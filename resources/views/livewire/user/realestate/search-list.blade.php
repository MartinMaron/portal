<div>
    <div class="max-w-7xl w-full mx-auto py-1 px-4 sm:px-0">
        <!-- Suchfeld -->
        <x-input.search wire:model.debounce.600ms="filter.search"></x-input.search>

        <!-- Realestates List -->
        <div class="mt-6 w-full grid grid-cols-1 gap-4 sm:grid-cols-2">
            @foreach ($filtered as $realestate)

                <div class="max-w-1/4 col-span-1 bg-sky-50 dark:bg-slate-800 shadow-md divide-y divide-gray-200 rounded-lg">
                    <div class="p-2 mb-2">
                        <div class="flex truncate border-sky-100 mx-1 my-2 ">
                            <div class="w-full">
                                <div class="flex justify-between items-center space-x-3 ">
                                    <h3 class="line-clamp-1 text-lg text-gray-900 dark:text-slate-100 truncate font-mdmedium text- md:font-bold md:text-md">{{ $realestate->street }}</h3>
                                    @if ($realestate->abrechnungssetting != null)
                                        <h3 class="line-clamp-1 text-lg text-gray-900 dark:text-slate-100 truncate font-mdmedium text- md:font-bold md:text-md">{{ $realestate->abrechnungssetting->period_from_editing. '-'. $realestate->abrechnungssetting->period_to_editing }}</h3>
                                    @endif    
                                </div>
                                <p class="mt-1 text-gray-500 dark:text-slate-100 truncate text-md">{{ $realestate->postCode.' '. $realestate->city }}</p>
                            </div>
                        </div>
                        <div class="text-sky-900 dark:text-sky-100 text-xs font-semibold">
                            @if ($realestate->heizkosten)
                                <span class="flex-shrink-0 inline-block px-2 my-0.5 bg-sky-200 dark:bg-slate-600 rounded-full">Heizkosten</span>
                            @endif
                            @if ($realestate->miete)
                                <span class="flex-shrink-0 inline-block px-2 my-0.5 bg-sky-200 dark:bg-slate-600 rounded-full">Wärmedienst Gerätemiete</span>
                            @endif
                            @if ($realestate->betriebskosten)
                                <span class="flex-shrink-0 inline-block px-2 my-0.5 bg-sky-200 dark:bg-slate-600 rounded-full">Betriebskosten</span>
                            @endif
                            @if ($realestate->rauchmelder)
                                <span class="flex-shrink-0 inline-block px-2 my-0.5 bg-sky-200 dark:bg-slate-600 rounded-full">Rauchmelder</span>
                            @endif
                            @if ($realestate->uviactive)
                                <span class="flex-shrink-0 inline-block px-2 my-0.5 bg-sky-200 dark:bg-slate-600 rounded-full">Verbraucherinformationen</span>
                            @endif
                        </div>
                        
                    </div>
                    <div>
                        <!-- <div class="flex -mt-px divide-x divide-gray-200"> -->
                        <div class="flex h-8 m-2 justify-start items-center">
                            <a href="{{route('user.realestate', $realestate)}}" class="inline-flex mr-6 px-1 py-2 text-sm font-medium text-gray-700 dark:text-slate-900 border border-transparent rounded-br-lg hover:text-gray-500 dark:hover:text-sky-900">
                                <i class="text-lg fad fa-home dark:text-slate-100 "></i>
                                <span class="ml-3 dark:text-slate-100">Bearbeiten</span>
                            </a>
                            @if ($realestate->nutzerlisteactive)
                                <a href="{{route('user.realestateOccupantList', $realestate)}}" class="py-4 px-2 sm:px-6 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                    @if ($realestate->abrechnungssetting !=null && $realestate->abrechnungssetting->nutzerlisteDone)
                                        <i class="fa-kit fa-solid-users-circle-check text-green-500 dark:text-green-800 text-lg sm:text-xl"></i>
                                    @else
                                        <x-icon.fonts.users class="_icon sm:text-xl dark:text-slate-200 hover:dark:text-slate-500 text-sky-600 hover:text-sky-800">
                                        </x-icon.fonts.users>
                                    @endif
                                </a>
                            @endif
                            @if ($realestate->kosteneingabe)
                                <a href="{{route('user.costs', $realestate)}}" class="py-4 px-3 sm:px-6 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                    @if ($realestate->abrechnungssetting !=null && $realestate->abrechnungssetting->brennstofflisteDone)
                                        <i class="fa-kit fa-solid-file-signature-circle-check text-green-500 dark:text-green-800 text-lg sm:text-xl"></i>
                                    @else
                                        <x-icon.fonts.file-signature class="_icon sm:text-xl dark:text-slate-200 hover:dark:text-slate-500 text-sky-600 hover:text-sky-800">
                                        </x-icon.fonts.file-signature>
                                    @endif
                                </a>
                                <a href="{{route('user.heizkostenliste', $realestate)}}" class="py-4 px-3 sm:px-6 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                    @if ($realestate->abrechnungssetting !=null && $realestate->abrechnungssetting->heizkostenlisteDone)
                                        <i class="_icon fa-kit fa-solid-file-pen-circle-check text-green-500 dark:text-green-800 text-lg sm:text-xl"></i>
                                    @else
                                        <i class="_icon fa-solid fa-file-pen text-lg sm:text-xl dark:text-slate-200 hover:dark:text-slate-500 text-sky-600 hover:text-sky-800"></i>   
                                    @endif
                                </a>
                                @if ($realestate->betriebskosten)
                                    <a href="{{route('user.betriebskostenliste', $realestate)}}" class="py-3 px-2 sm:px-6 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                        @if ($realestate->abrechnungssetting !=null && $realestate->abrechnungssetting->betreibskostenDone)
                                            <i class="_icon fa-kit fa-regular-file-signature-circle-check text-green-500 dark:text-green-800 text-lg sm:text-xl"></i>
                                        @else
                                            <i class="_icon fa-regular fa-file-signature text-lg sm:text-xl dark:text-slate-200 hover:dark:text-slate-500 text-sky-600 hover:text-sky-800"></i>   
                                        @endif
                                    </a>
                                @endif
                                
                            @endif
                        </div>
                       
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 my-5">
            {{ $filtered->onEachSide(2)->links() }}
        </div>
    </div>
</div>


