<div>
    <div class="w-full px-4 py-1 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div>
            <x-input.search wire:model.debounce.600ms="filter"></x-input.search>
        </div>
        <div class="grid w-full grid-cols-1 gap-4 mt-6 sm:grid-cols-2 lg:grid-cols-3">
            @if ($rows->count()!=0)
               @foreach ($rows as $occupant)
                <div>
                    <div x-data="{ open: true }" class="col-span-1 divide-y divide-gray-200 rounded-lg shadow-md max-w-1/4 bg-sky-100 dark:bg-slate-800">
                        <div class="flex items-center justify-between w-full pt-2 space-x-6 ">
                            <div class="flex-1 truncate border-sky-200 ">
                                <div x-on:click="open = ! open"  class="w-full">
                                    <div>
                                        <div class="flex items-center space-x-3 ">
                                            <h3 class="flex-1 text-lg text-center text-gray-900 dark:text-slate-300 truncate line-clamp-1 font-mdmedium text- md:font-bold md:text-md">{{ $occupant->lage. ' - '. $occupant->nachname. '' }}</h3>
                                        </div>
                                    </div>
                                    <p class="flex-1 text-center text-gray-500 dark:text-slate-400 truncate text-md">{{ $occupant->street.', '. $occupant->postcode. ' '. $occupant->city }}</p>
                                </div>
                                <div x-show="open" x-transition>
                                    <div class="mt-5">
                                        <livewire:user.occupant.verbrauchsinfo.occupant-view :pOccupant='$occupant'/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>


        @if ($rows->count()==0)
            <livewire:not-found />
        @endif
    </div>
</div>
