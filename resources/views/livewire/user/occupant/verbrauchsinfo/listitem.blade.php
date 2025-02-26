
<div class="hidden md:flex pt-1 text-lg text-center dark:text-slate-300
    {{ $singleVerbrauchsinfo->hk ? 'odd:bg-green-100 dark:odd:bg-green-950 even:bg-green-50 dark:even:bg-green-900' :'even:bg-red-50 dark:even:bg-red-950 odd:bg-red-100 dark:odd:bg-red-900  '}} ">
    <div class="basis-1/4">
        {{ $singleVerbrauchsinfo->datum}}
    </div>
    <div class="basis-1/4">
        {{ $singleVerbrauchsinfo->VerbrauchAktDisplay}}
    </div>
    <div class="basis-1/4">
        {{ $singleVerbrauchsinfo->VerbrauchVorjDisplay}}
    </div>
    <div class="basis-1/4">
        {{ $singleVerbrauchsinfo->einheit->shortname}}
    </div>
</div>    

    <!-- potrzebne do wyswietlenia kolorow wierszy -->

<div>
</div>

    <!--koniec potrzebne do wyswietlenia kolorow wierszy -->

<div class= "max-w-sm pb-4 m-1 sm:hidden dark:text-slate-200">
        <div class="text-sm font-bold text-center border rounded-t-lg sm:flex-1 bg-sky-100 dark:bg-slate-800 border-sky-100 dark:border-slate-950 basis-1/6">
            <div class="flex justify-center basis-1/2">
                <x-table.heading class="items-center text-sm text-center " 
                sortable multi-column wire:click="sortBy('datum')" 
                :direction="$sorts['datum'] ?? null">
                {{ $singleVerbrauchsinfo->zeitraum_akt }}
                </x-table.heading>
            </div>
        </div>
    <div class="text-sm border rounded-b-lg border-sky-100 dark:border-slate-950">
        <div class="flex justify-around mt-1 text-center">
            <div class="basis-1/6">
                <span class="text-xs font-thin ">Aktuell</span>
            </div>
            <div class="basis-1/6">
                <span class="text-xs font-thin ">Vorjahr</span>
            </div>
        </div>

        <div class="flex justify-around pb-1 mt-1">
            <div class="flex text-lg font-bold text-center basis-1/6">
                <span class="{{ $singleVerbrauchsinfo->ww ? 'text-red-800 dark:text-red-400 ' : 'text-green-600 ' }}">
                {{ $singleVerbrauchsinfo->VerbrauchAktDisplay}}
                </span>
                <span class="{{ $singleVerbrauchsinfo->ww ? 'text-red-800 dark:text-red-400 ' : 'text-green-600 ' }}">
                {{ $singleVerbrauchsinfo->einheit->shortname}}
                </span>
            </div>
            <div class="flex text-lg font-bold text-center basis-1/6">
                <span class="{{ $singleVerbrauchsinfo->ww ? 'text-red-800 dark:text-red-400 ' : 'text-green-600 ' }}">
                {{ $singleVerbrauchsinfo->VerbrauchVorjDisplay}}
                </span>
                <span class="{{ $singleVerbrauchsinfo->ww ? 'text-red-800 dark:text-red-400 ' : 'text-green-600 ' }}">
                {{ $singleVerbrauchsinfo->einheit->shortname}}
                </span>
            </div>
        </div>
    </div>
</div>

