<div>
    <div class="justify-center hidden w-full px-4 py-1 mx-auto mt-8 md:flex max-w-7xl ">
        <div class="mb-6 ">
            <span class="font-thin text-xl md:font-bold {{ $verbrauchsinfo->ww ? 'text-red-800 dark:text-red-400' : 'text-green-600 ' }}
            ">
            {{ $verbrauchsinfo->nutzergrup_name}}
            </span>
        </div>
        <div class="px-4">
            <x-icon.fonts.ww_hk class="text-3xl" 
            :hk='$verbrauchsinfo->hk' >
            </x-icon.fonts.ww_hk>
        </div>
    </div>

    <div class="hidden md:flex md:justify-around md:items-center ">
        <div class="flex mt-1 text-lg font-bold text-center border rounded-t-lg md:flex-1 bg-sky-100 dark:bg-slate-800 border-sky-100 dark:border-slate-950 dark:text-slate-200 basis-1/6">
            <div class="flex justify-center basis-1/4">
                <div class="">Monat</div>
                <div class="mt-1">
                    <x-table.heading class="items-center text-center text-md" 
                    sortable multi-column wire:click="sortByDatum('datum')" 
                    :direction="$sorts['datum'] ?? null">
                    </x-table.heading>
                </div>
            </div>
            <div class="basis-1/4">
                <span class="">Aktuell</span>
            </div>
            <div class="basis-1/4">
                <span class="">Vorjahr</span>
            </div>
            <div class="basis-1/4">
                <span class="">Einheit</span>
            </div>
        </div>
    </div>

    <div class="flex justify-center sm:hidden">
        <div class="mb-1 text-lg md:text-xl font-bold 
        {{ $verbrauchsinfo->ww ? 'text-red-800 dark:text-red-400' : 'text-green-600 ' }}">
        {{ $verbrauchsinfo->nutzergrup_name}}
        </div>
        <div class="px-4">
            <x-icon.fonts.ww_hk class="text-2xl" 
            :hk='$verbrauchsinfo->hk' >
            </x-icon.fonts.ww_hk>
        </div>
    </div>
</div>
