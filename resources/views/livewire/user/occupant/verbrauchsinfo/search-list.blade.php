<div class="w-full px-4 py-1 mx-auto max-w-7xl sm:px-6 lg:px-8 ">
    <div class="">
        <livewire:user.occupant.occupant-header :occupant='$occupant'/>
    </div>
    @if ($nutzergruppen->count()!=0)
    <div class="pb-4 mt-16">
        <div class="mb-5 text-xl font-bold text-center border-b-2 md:text-2xl border-sky-400 w-max-md md:bloc">
            VERLAUF DER VERBRÄUCHE
        </div>

        @foreach ($nutzergruppen as $verbrauchsinfo)
            <div class="">
                <livewire:user.occupant.verbrauchsinfo.header :verbrauchsinfo='$verbrauchsinfo' :sorts='$sorts' :wire:key="'verbrauchsinfo-listitem-header'.$verbrauchsinfo->id" key="{{ now() }}"/>
            </div>

            <div class="md:border md:rounded-b-lg md:border-sky-100 dark:md:border-slate-950">
                @forelse ($this->getVerbrauchsinfosByNutzergrupe($verbrauchsinfo->nutzergrup_id) as $singleVerbrauchsinfo)
                <livewire:user.occupant.verbrauchsinfo.listitem :singleVerbrauchsinfo='$singleVerbrauchsinfo' :wire:key="'verbrauchsinfo-listitem'.$verbrauchsinfo->id"  key="{{ now() }}"/>

                @endforeach
            </div>
        @endforeach

    @else
        <livewire:not-found />
    @endif
    </div>
</div>
