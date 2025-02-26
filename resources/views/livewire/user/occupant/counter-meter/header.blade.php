<div class="dark:text-slate-200">
    <div class="justify-center hidden w-full px-4 py-1 mx-auto mt-8 text-2xl md:flex max-w-7xl">
        <div class="mb-1 text-lg font-bold
        {{ $counterMeter->ww ? 'text-red-800 dark:text-red-400 ' : 'text-green-600 dark:text-green-500' }}">
        {{ $counterMeter->nutzergrup_name }}
        </div>
        <div class="px-4">
            <x-icon.fonts.ww_hk class="text-3xl"
            :hk='$counterMeter->hk' >
            </x-icon.fonts.ww_hk>
        </div>
    </div>

    <div class="hidden mt-4 md:flex md:justify-betweeen md:items-center">
        <div class="flex mt-1 text-lg font-bold text-center border rounded-t-lg md:flex-1 bg-sky-100 dark:bg-slate-800 border-sky-100 dark:border-slate-950">
            <div class="grid grid-cols-2 mt-1 {{ $counterMeter->nr == $counterMeter->funkNr ? 'basis-1/4' : 'basis-1/5' }}">
                <div class="font-bold text-right text-md">
                    Nr.:
                </div>
                <div class="mt-1">
                    <x-table.heading class="" sortable multi-column wire:click="sortByNr('nr')" :direction="$sorts['nr'] ?? null">
                    </x-table.heading>
                </div>
            </div>
            <div class="{{ $counterMeter->nr == $counterMeter->funkNr ? '' : 'basis-1/5' }} flex justify-center">
                <div class="inline-block align-bottom">
                <span class="font-bold text-md {{ $counterMeter->nr == $counterMeter->funkNr ? 'hidden' : 'visible' }} ">Funknr.: </span>
                </div>
            </div>
            <div class="{{ $counterMeter->nr == $counterMeter->funkNr ? 'basis-1/4' : 'basis-1/5' }}">
                <span class="">mon. Verbrauch</span>
            </div>
            <div class="{{ $counterMeter->nr == $counterMeter->funkNr ? 'basis-1/4' : 'basis-1/5' }}">
                <span class="">Einheit</span>
            </div>
        </div>
    </div>

    <div class="flex justify-center sm:hidden">
        <div class="mb-1 text-lg md:text-xl font-bold
        {{ $counterMeter->ww ? 'text-red-800 dark:text-red-400' : 'text-green-600 dark:text-green-500' }}">
        {{ $counterMeter->nutzergrup_name }}
        </div>
        <div class="px-4">
        <x-icon.fonts.ww_hk class="text-2xl"
        :hk='$counterMeter->hk' >
        </x-icon.fonts.ww_hk>
        </div>
    </div>
</div>
