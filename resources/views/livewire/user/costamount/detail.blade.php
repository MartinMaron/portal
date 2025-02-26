
    <form wire:submit.prevent="closeCostAmountDetailModal(true)">
        <x-modal.dialog class="bg-sky-50" minWidth="640px" maxWidth="800px"
               wire:model="showCostAmountEditModal">
            <!-- Dialog Title -->
            <x-slot name="title">
                <div class="flex flex-row justify-between">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-sky-100">
                        {{-- <i class="text-sky-800 fa-solid fa-trash-can"></i> --}}
                        <x-icon.fonts.pencil class="text-xs text-sky-500 hover:text-sky-800  px-2 ">                                       
                        </x-icon.fonts.pencil>
                    </div>
                </div>
                @if ($errors->isNotEmpty())
                    <div class="block text-sm bg-red-100 border border-red-400 text-red-700 px-1 py-1 rounded relative mb-2" role="alert">
                        <span class="block sm:block"><strong class="font-bold">Uups! Einige Informationen fehlen oder sind nicht korrekt. </strong>
                            @foreach ($errors->all() as $error)
                                    <span class="block sm:block">- {{ $error  }}</span>
                            @endforeach
                        </span>
                    </div>
                @endif
            </x-slot>
            <!-- Dialog Content -->
            <x-slot name="content">
                <div>
                    <div
                    > 
                    <x-input.group
                    class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hoheOnError="h-30" hohe="h-20 sm:h-10"
                    for="costAmount.datum" label="Datum" :error="$errors->first('costAmount.datum')">
                        <x-input.date
                            wire:model.lazy="costAmount.datum"
                            id="costamount-detailmodal-datum"
                            class="bg-sky-50 sm:h-8"
                            
                        >
                        </x-input.date>
                    </x-input.group>
                    <!-- Verbrauch -->
                    @if ($showConsumptionField)
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="costAmount.consumption_editing" label="Verbrauch" :error="$errors->first('costAmount.consumption_editing')">
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="costAmount.consumption_editing" id="costAmount.consumption_editing" placeholder="0,000" />
                        </x-input.group>
                    @endif

                        @if ($showNetto)
                            <x-input.group
                            class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                            for="costAmount.netto" label="Nettobetrag" :error="$errors->first('costAmount.netto')">
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="costAmount.netto" id="netto" placeholder="0" />
                            </x-input.group>
                        @else
                            <x-input.group
                                class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                                for="costAmount.brutto" label="Betrag" :error="$errors->first('costAmount.brutto')">
                                    <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="costAmount.brutto" id="brutto" placeholder="0" />
                            </x-input.group>
                        @endif
                        @if ($co2Tax)
                             <!-- CO2 Abgabe -->
                            <x-input.group
                            class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                            for="costAmount.coconsupmtion" label="CO2-Abgabe [kg]" :error="$errors->first('costAmount.coconsupmtion')">
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="costAmount.coconsupmtion" id="coconsupmtion" placeholder="0" />
                            </x-input.group>

                            @if ($showNetto)
                            <!-- Netto -->
                                <x-input.group
                                class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                                for="costAmount.conetto" label="CO2-Nettobetrag" :error="$errors->first('costAmount.conetto')">
                                    <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="costAmount.conetto" id="conetto" placeholder="0,00" />
                                </x-input.group>
                            @else                        
                            <!-- Brutto -->
                            <x-input.group
                                class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                                for="costAmount.cobrutto" label="CO2-Betrag" :error="$errors->first('costAmount.cobrutto')">
                                    <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="costAmount.cobrutto" id="cobrutto" placeholder="0,00" />
                                </x-input.group>
                            @endif
                        @endif

                        @if ($showHaushaltsnahField)
                            <!-- Haushaltsnah -->
                            <x-input.group class="border-0" for="costAmount.haushaltsnah" label="Betrag nach §35a" :error="$errors->first('costAmount.haushaltsnah')">
                            <x-input.text class="bg-sky-50 sm:h-8" wire:model.lazy="costAmount.haushaltsnah" id="costAmount.haushaltsnah" placeholder="0,00" />
                        </x-input.group>


                        @endif
                        <!-- Bemerkung-->  
                        <x-input.group
                            hohe="h-30"
                            hoheLabel="h-30 sm:h-full sm:pt-3"
                            bottom=false for="bemerkung" label="Bemerkung für die Abrechnung" :error="$errors->first('costAmount.bemerkung')">
                            <x-input.textarea  wire:model="costAmount.bemerkung" id="bemerkung" placeholder="..." />
                        </x-input.group>
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary wire:click="closeCostAmountDetailModal(false)">Abbrechen</x-button.secondary>
                <x-button.delete type="submit">Speichern</x-button.delete>
            </x-slot>
        </x-modal.dialog>
    </form>

















