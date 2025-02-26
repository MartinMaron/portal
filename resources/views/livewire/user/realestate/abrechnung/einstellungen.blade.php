<div class="sm:grid sm:grid-cols-6 sm:gap-2">
    <div class="sm:col-span-6">
        <div class="flex justify-start items-center p-2 mt-4 h-8 border-black border-b-2">
            <div class="font-bold text-xl">
                Allgemeine Einstellungen
            </div>
        </div>
    </div>
    <div class="block sm:col-span-3">
        <!-- eingabe netto-->
        <x-input.group for="einstellungen-eingabeCostNetto" inputBorderless="true" labelDirection="text-left" labelsColSpan="4" slotColSpan="2"  hohe="h-10" label="Kosteneingabe als Nettobeträge" :error="$errors->first('realestate.eingabeCostNetto')">
            <div class="flex justify-between items-center">
                <div>
                    <x-input.toggle wire:model="realestate.eingabeCostNetto"  width=8 id="einstellungen-eingabeCostNetto" ></x-input.toggle>
                </div>
            </div>
        </x-input.group>
        <!-- eingabe mit Datum-->
        <x-input.group hohe="h-8" for="einstellungen-eingabeCostOhneDatum" inputBorderless="true" labelDirection="text-left" labelsColSpan="4" slotColSpan="2"  hohe="h-10" for="einstellungen-eingabeCostOhneDatum" label="Kosteneingabe mit Rechnungsdatum" :error="$errors->first('realestate.eingabeCostOhneDatum')">
            <div class="flex justify-between items-center">
                <div>
                    <x-input.toggle wire:model="realestate.eingabeCostDatum"  width=8 id="einstellungen-eingabeCostOhneDatum" ></x-input.toggle>
                </div>
            </div>
        </x-input.group>

        <x-input.group for="einstellungen-stromkosten" labelDirection="text-left" label="Heizstrom Pauschalbetrag aus Brennstoffkosten in [%]" labelsColSpan="4" slotColSpan="2" :error="$errors->first('realestate.stromkosten')">
            <x-input.text class=" sm:h-8" wire:model.lazy="einstellungen.stromkosten" />
        </x-input.group>
    </div>
    <div class="sm:col-span-3">
        <x-input.group for="einstellungen-nabi_nr" labelDirection="text-left" label="IBAN" :error="$errors->first('realestate.nabi_nr')">
            <x-input.text class=" sm:h-8" wire:model.lazy="einstellungen.nabi_nr" />
        </x-input.group>
        <x-input.group for="einstellungen-nabi_inhaber" labelDirection="text-left" label="Kontoinhaber" :error="$errors->first('realestate.nabi_inhaber')">
            <x-input.text class=" sm:h-8" wire:model.lazy="einstellungen.nabi_inhaber" />
        </x-input.group>
    </div>
    <div class="sm:col-span-6">
        <div class="flex justify-start items-center p-2 mt-4 h-8 border-black border-b-2">
            <div class="font-bold text-xl">
                Einstellungen zu Kohlendioxidkostenaufteilungsgesetz (CO2KostAufG) 
            </div>
        </div>
    </div>
    <div class="sm:col-span-3">
        <x-input.group for="einstellungen-co2_anschluss_nach_2022" inputBorderless="true" labelDirection="text-left" hohe="h-10" label="Wärmeanschluss des Gebäudes nach 01.01.2023" labelsColSpan="4" slotColSpan="2" :error="$errors->first('einstellungen.co2_anschluss_nach_2022')">
            <div class="flex justify-between items-center">
                <div>
                    <x-input.toggle wire:model="einstellungen.co2_anschluss_nach_2022"  width=8 id="einstellungen-co2_anschluss_nach_2022" ></x-input.toggle>
                </div>
            </div>
        </x-input.group>
    </div>
    <div class="sm:col-span-3">
        
    </div>
    <div class="sm:col-span-3">
        <!-- eingabe kennzeichen WEG-->
        <x-input.group for="einstellungen-co2_kennzeichen_1_9" inputBorderless="true" labelDirection="text-left" hohe="h-10" label="Denkmalschutz: Kennzeichen 1 §9 (nur 50 % aufteilen)" labelsColSpan="4" slotColSpan="2" :error="$errors->first('einstellungen.co2_kennzeichen_1_9')">
            <div class="flex justify-between items-center">
                <div>
                    <x-input.toggle wire:model="einstellungen.co2_kennzeichen_1_9"  width=8 id="einstellungen-co2_kennzeichen_1_9" ></x-input.toggle>
                </div>
            </div>
        </x-input.group>
        <x-input.group for="einstellungen-co2_kennzeichen_2_9" inputBorderless="true" labelDirection="text-left" hohe="h-10" label="Denkmalschutz: Kennzeichen 2 §9 (Keine Aufteilung)" labelsColSpan="4" slotColSpan="2" :error="$errors->first('einstellungen.co2_kennzeichen_2_9')">
            <div class="flex justify-between items-center">
                <div>
                    <x-input.toggle wire:model="einstellungen.co2_kennzeichen_2_9" inputBorderless="true"  width=8 id="einstellungen-co2_kennzeichen_2_9" ></x-input.toggle>
                </div>
            </div>
        </x-input.group>        
    </div> 
    <div class="sm:col-span-3">
        <!-- eingabe kennzeichen WEG-->
        <x-input.group for="einstellungen-co2_kennzeichen_WEG" labelDirection="text-left" hohe="h-10" label="WEG (Nur Ausweis der CO2-Kosten - Keine Aufteilung)" labelsColSpan="4" slotColSpan="2" :error="$errors->first('einstellungen.co2_kennzeichen_WEG')">
            <div class="flex justify-between items-center">
                <div>
                    <x-input.toggle wire:model="einstellungen.co2_kennzeichen_WEG"  width=8 id="einstellungen-co2_kennzeichen_WEG" ></x-input.toggle>
                </div>
            </div>
        </x-input.group>
        <x-input.group for="einstellungen-co2_wohngeb" labelDirection="text-left" hohe="h-10" label="Wohngeb. oder Nichtwohngeb. (Aufteilung 50% - 50%)" labelsColSpan="4" slotColSpan="2" :error="$errors->first('einstellungen.co2_wohngeb')">
            <div class="flex justify-between items-center">
                <div>
                    <x-input.toggle wire:model="einstellungen.co2_wohngeb"  width=40 id="einstellungen-co2_wohngeb" >{{ $this->einstellungen->gebart }}</x-input.toggle>
                </div>
            </div>
        </x-input.group>
        
    </div>     
    
    <div class="sm:col-span-6">
        <div class="flex justify-end items-center p-2 mt-4 h-8">
            <div class="">

            </div>
            <div wire:click="commit" >
                @if (!$this->realestate->abrechnungssetting->brennstofflisteDone)
                    <x-button.secondary class="flex justify-items-end">
                        Einstellungen speichern
                    </x-button.secondary>
                @endif                
            </div>
        </div>
    </div>
      
</div>

