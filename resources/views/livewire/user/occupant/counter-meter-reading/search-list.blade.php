<div class="w-full px-4 py-1 mx-auto max-w-7xl sm:px-6 lg:px-8 ">
    <div>
        <livewire:user.occupant.occupant-header :occupant='$occupant' />
    </div>
    @if ($rows->count()!=0)
        <div class="md:text-center">{{ $rows->first()->nr }}
        </div>
    @endif

    <div class="mt-16">
        <div class="mb-5 text-xl font-bold text-center border-b-2 border-sky-400 md:text-2xl">
            Stände anzeigen {{ '['. $rows->first()->einheit->shortname. ']' }}
        </div>

        @if ($rows->count()!=0)
            
            <div class="dark:text-slate-200">
                <livewire:user.occupant.counter-meter-reading.header :sorts='$sorts' :wire:key="'counter-meter-reading-listitem-header'.$counterMeter->id" key="{{ now() }}"/>
            </div>

            <div class="justify-between m-auto text-xs text-center dark:text-slate-200 border rounded-b-lg border-sky-100 dark:border-slate-950 md:text-lg md:w-5/6">
                @foreach ($rows as $counterMeter)

                    <div class= "{{ $rows->first()->hk ? 'even:bg-green-50 dark:even:bg-green-950 odd:bg-green-100 dark:odd:bg-green-900' :'even:bg-red-50 dark:even:bg-red-950 odd:bg-red-100 dark:odd:bg-red-900'}}">
                        <livewire:user.occupant.counter-meter-reading.listitem :counterMeter='$counterMeter' :wire:key="'counter-meter-reading-listitem-'.$counterMeter->id"  key="{{ now() }}"/>
                    </div>
                @endforeach

            </div>
            
        @else 
            <livewire:not-found />
        @endif
    </div>
</div>
