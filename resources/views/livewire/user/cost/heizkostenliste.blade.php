<div>
    <!-- Main -->
    <div class="max-w-7xl w-full sm:px-1 lg:px-1 mb-40 mx-auto kostenliste">
        <div class="flex items-center mt-3">
            <div class="basis-1/4"></div>
            <div class="basis-2/4 page-title">
                <div class="">WEITERE HEIZKOSTEN</div>
                @if ($this->realestate->abrechnungssetting->heizkostenlisteDone)
                    <div class="text-sm">Daten für ausgewählten Abrechnungszeitraum bereits an neko versendet !</div>
                @endif
            </div>
            <div class="basis-1/4 flex justify-end" wire:click="setDone">
                @if (! $this->realestate->abrechnungssetting->heizkostenlisteDone)
                    <x-button.complete-abr></x-button.complete-abr>
                @endif
            </div>
        </div>
        <div class="space-y-1 mt-4 columnheader pb-3 mb-12 rounded-lg">
            <!-- Überschrift -->
            <div class="flex flex-row items-center font-semibold">
                <div class="basis-2/3 flex text-center items-center">
                    <div
                        class="basis-2/3 text-left px-2 flex rounded-md "
                        tabindex="-1">
                        <span class="py-1 text-right line-clamp-1">Kostenbezeichnung</span>
                    </div>

                    <div class="basis-1/3 rounded-md">
                        <span class="line-clamp-1">Bearbeitungshinweis</span>
                    </div>
                </div>
                <div class="basis-1/3 flex gap-2 text-center">
                    <div class="basis-1/3">
                        @if ($this->hasConsumptionByType('BEH', $this->realestate) 
                            || $this->hasConsumptionByType('KWA', $this->realestate)
                            || $this->hasConsumptionByType('KWK', $this->realestate)
                            || $this->hasConsumptionByType('ZKW', $this->realestate))
                            <span class="">Verbrauch</span>                        
                        @endif
                    </div>
                    <div class="basis-1/3">
                        @if ($this->hasHaushaltsnahByType('BEH', $this->realestate) 
                            || $this->hasHaushaltsnahByType('DIR', $this->realestate)
                            || $this->hasHaushaltsnahByType('HNK', $this->realestate)
                            || $this->hasHaushaltsnahByType('KWA', $this->realestate)
                            || $this->hasHaushaltsnahByType('KWK', $this->realestate)
                            || $this->hasHaushaltsnahByType('ZKW', $this->realestate)
                            || $this->hasHaushaltsnahByType('ZWA', $this->realestate)
                            || $this->hasHaushaltsnahByType('ZUK', $this->realestate)
                            )
                            <span class="">§ 35c EStG</span>
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
            <!-- liste der Kosten -->
            @forelse ($costtypes as $costtype)
            <div class="flex justify-between columnheader">
                <div class="flex justify-start items-center mb-1 ml-2 mt-3 mr-5 gap-2">
                    <button wire:click="addCostModal({{ $costtype }})"
                        tabindex="-1"
                        class="fa-regular fa-circle-plus text-2xl " >
                    </button>
                    <div class="text-lg pr-1 font-semibold tracking-wider items-end">
                        {{ $costtype->costtype->caption. ' ('. number_format($this->getCostByType($costtype->costtype_id, $this->realestate)->pluck('gros')->sum(), 2, ',', '.') . ' €)'  }}
                    </div>
                </div>
            </div>
                @forelse ($this->getCostByType($costtype->costtype_id, $this->realestate) as $cost)
                    <div class="px-1">
                        <livewire:user.cost-amount.detail-input-hk :cost='$cost' :netto='false' :inputWithDatum='false' :wire:key="'list-cost-costamountinput-'.$cost->id" key="{{ now() }}"/>
                    </div>
                @empty
                    <div class="flex justify-center items-center space-x-2 bg-sky-100">
                        <span class="font-medium py-8 text-cool-gray-400 text-xl">nichts gefunden...</span>
                    </div>
                @endforelse
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
            <livewire:user.cost.detail :wire:key="'modal-realestate-cost-detail'"/>
        </div>
        <div>
            <livewire:user.dialog.neko-message-box :wire:key="'neko-message-box'"/>
        </div>
    </div>
</div>





