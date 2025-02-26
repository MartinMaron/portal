<div>
    <!-- Main -->
    <div class="max-w-7xl w-full mx-auto sm:px-1 lg:px-1 m-0 mb-24 kostenliste">
        <div class="text-3xl pt-3 font-extrabold text-center w-full flex my-3 page-title ">
            <div class="basis-1/4 flex justify-start">
                <button wire:click="raise_AddCostModal({{ $current }})"
                tabindex="-1">
                <i class="fa-regular fa-circle-plus text-3xl" ></i>
                </button></div>
            <div class="basis-2/4 page-title text-3xl pt-3 font-bold  text-center w-full">
                <div class="">BETRIEBSKOSTEN</div>
                @if ($this->realestate->abrechnungssetting->betreibskostenDone)
                    <div class="text-sm">Daten für ausgewählten Abrechnungszeitraum bereits an neko versendet !</div>
                @endif
            </div>
            <div class="basis-1/4 flex justify-end" wire:click="setDone()">
                @if (! $this->realestate->abrechnungssetting->betreibskostenDone)
                    <x-button.complete-abr></x-button.complete-abr>
                @endif
            </div>
        </div>
        <!-- Überschrift -->
        <div class="flex flex-row columnheader items-center justify-start border-b-2 border-slate-400">
            <div class="basis-2/3 flex text-center items-center">
                <div 
                    class="basis-1/3 text-left px-2 flex rounded-md "
                    tabindex="-1">
                    <span class="py-1 text-right line-clamp-1">Kostenbezeichnung</span>
                </div>

                <div class="basis-1/3 rounded-md">
                    <span class="line-clamp-1">Bearbeitungshinweis</span>
                </div>
                <div class="basis-1/3 px-4 rounded-md ">
                    letzte Abrechnung
                </div>
            </div>
            <div class="basis-1/3 flex gap-2 text-center">
                <div class="basis-1/3">
                    @if ($this->hasConsumptionByType('BEK'))
                       <span class="">Verbrauch</span>
                    @endif
                </div>
                <div class="basis-1/3">
                    @if ($this->hasHaushaltsnahByType('BEK'))
                        <div class="">
                        <span class="">§ 35c EStG</span>
                        </div>
                    @endif
                </div>
                <div class="basis-1/3">
                    @if ($this->realestate->eingabeCostNetto)
                        <span class="">Nettobetrag</span>
                    @else
                        <span class="">Betrag</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- liste der Kostearten -->
        <div class="border-0 bg-slate-700">
            @forelse ($filtered as $cost)
            <div class="">
                <livewire:user.costamount.detail-input :cost='$cost' :netto='false' :inputWithDatum='false' :wire:key="'list-cost-costamountinput-'.$singleCost->id" key="{{ now() }}"/>
            </div>
            @empty
                <div class="flex justify-center items-center space-x-2 bg-sky-100">
                    <span class="font-medium py-8 text-cool-gray-400 text-xl">nichts gefunden...</span>
                </div>
            @endforelse
        </div>
    
    </div>
    <div class="xs:max-w-xs xs:w-xs">
        <!-- Save Cost Modal -->
        <div>
            <livewire:user.cost.detail :cost='$current' :netAmountInput='$nettoInputMode' :costinvoicingtype="'HZ'" :wire:key="'modal-realestate-cost-detail'"/>
        </div>
        <div>
            <livewire:user.costamount.detail :wire:key="'modal-realestate-costamount-detail'"/>
        </div>
         <!-- for Delete or Confirm -->
         <div>
            <livewire:user.dialog.neko-message-box :wire:key="'neko-message-box'"/>
        </div>
    </div>
</div>




