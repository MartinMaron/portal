<div>
   {{-- small screen --}}
    <div class="sm:hidden">
        <div class="flex items-center">
            @if ($showStandardIcon)
                <x-icon.fonts.poeple class="inline-block pr-2 align-text-bottom text-sky-700 dark:text-slate-400 fa-lg"></x-icon.fonts.poeple>
            @endif
            @if ($addAction)
                <x-icon.fonts.users-add wire:click='raise_CreateVerbrauchsinfoUserEmailModal' class="inline-block pt-1 pr-2 align-text-bottom text-sky-700 fa-lg "></x-icon.fonts.users-add>
            @endif
            <div class="flex-1 text-sm text-gray-900 dark:text-slate-300 truncate line-clamp-1 sm:font-semibold sm:text-md">{{ $occupant->lage. '-'. $occupant->nachname. ' '}}</div>
            </div>
        {{-- <div>{{ $occupant->street.', '. $occupant->postcode. ' '. $occupant->city }}</div> --}}
    </div>
    {{-- big screen --}}
    <div class="hidden sm:block">
        <div class="flex justify-center items-center py-1">
            @if ($showStandardIcon)
                <x-icon.fonts.poeple class="fa-xl text-sky-700 dark:text-slate-400"></x-icon.fonts.poeple>
            @endif
            @if ($addAction)
                <x-icon.fonts.users-add wire:click='raise_CreateVerbrauchsinfoUserEmailModal' class="mr-3 fa-2xl text-sky-700 hover:text-sky-300"></x-icon.fonts.users-add>
            @endif
            <div class="px-2 text-gray-900 dark:text-slate-400 truncate line-clamp-1 font-bold text-xl">{{ $occupant->lage. ' - '. $occupant->nachname. ' '}}</div>
            @if ($hasRealestateOccupantsDifferentAdresses)
                <div class="px-2 text-gray-900 dark:text-slate-400 truncate line-clamp-1 text-xl">{{ $occupant->street.' '. $occupant->houseNr. ', '. $occupant->postcode. ' '. $occupant->city }}</div>
            @endif
            
        </div>
    </div>
</div>
