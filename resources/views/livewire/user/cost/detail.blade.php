 
<form wire:submit.prevent="closeModal(true)">
 <x-modal.dialog class="bg-sky-50" minWidth="340px" maxWidth="2xl" wire:model.defer="showEditModal">
        <!-- Dialog Title -->
        <x-slot name="title">
            <div class="flex">
                @if ($cost->caption)
                    <div class="text-lg font-bold text-sky-500 dark:text-slate-300">{{ $cost->caption }}</div> <x-icon.fonts.pen-line class="text-sky-500 dark:text-slate-300 pl-10 h-6 mt-1" ></x-icon.fonts.pen-line>
                @else
                    <div class="text-lg font-bold text-sky-500 dark:text-slate-300">Neu</div> <x-icon.fonts.pen-line class="text-sky-500 dark:text-slate-300 pl-10 h-6 mt-1" ></x-icon.fonts.pen-line>
                @endif
            </div>
        </x-slot>
        <!-- Dialog Content -->
        <x-slot name="content">
            <div> 
                @if ($onlyConsumptionEdit!=true)
                    <!-- Kostebezeichnung-->  
                    <div>    
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="cost.caption" label="Bezeichnung" :error="$errors->first('cost.caption')"
                        >
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="cost.caption" id="cost-detail-cost.caption" placeholder="Bitte Kostenbezeichnung eintragen" />
                        </x-input.group> 
                    </div>
                @endif
                @if ($onlyConsumptionEdit!=true)
                
                <!-- Kostenart-->  
                    <div>
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="cost.costtype_id" label="Kostenart" :error="$errors->first('cost.costtype_id')"
                        >
                        <x-input.select
                            class="h-10 border-b bg-sky-50 sm:h-8 focus:border-0 w-full" wire:model="cost.costtype_id" id="cost-detail-cost.costtype_id" placeholder="Bitte auswählen" value="">
                            @foreach ($this->costtypes as $label)
                                <option class="h-10" value="{{ $label->id }}">
                                        {{ $label->caption }}
                                </option>
                            @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                
                    @endif
                @if ($onlyConsumptionEdit!=true)
                    <!-- Brennstoffart-->
                    <div class="{{ $cost->costtype_id == 'BRK' ? 'block' : 'hidden' }}">
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                            for="fueltype_id" label="Brennstoff" :error="$errors->first('cost.fueltype_id')"
                            >
                            <x-input.select
                            class="h-10 border-b bg-sky-50 sm:h-8 focus:border-0 w-full" wire:model="cost.fueltype_id" id="cost-detail-cost.fueltype_id" placeholder="Bitte auswählen" value="">
                                @foreach ($this->fueltypes as $label)
                                <option class="flex h-10" value="{{ $label->id }}">
                                    {{ $label->caption. ' ('. $label->einheit->shortname. ')'   }}
                                </option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                @endif

                @if ($cost->costtype_id =='BRK' && $cost->fueltype != null && $cost->fueltype->hasTank)
                    @if ($onlyConsumptionEdit!=true)
                        <!-- Anfangsstand-->  
                        <div>
                            <x-input.group
                            class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                            for="cost.start_value_editing" label="Anfangsstand" :error="$errors->first('cost.start_value_editing')"
                            >
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="cost.start_value_editing" id="cost-detail-cost.start_value_editing" placeholder="0" />
                            </x-input.group>
                        </div>
                        <!-- Anfangsstand Betrag-->  
                        <div>
                            <x-input.group
                            class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                            for="cost.start_value_amount_gros_editing" label="Anfangsstand Betrag" :error="$errors->first('cost.start_value_amount_gros_editing')"
                            >
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="{{ $netAmountInput ? 'cost.start_value_amount_net_editing' : 'cost.start_value_amount_gros_editing'}}" id="cost-detail-cost.start_value_amount_editing" placeholder="0" />
                            </x-input.group>  
                        </div>
                    @endif
                    <!-- Endstand Tank-->  
                    <div>
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="cost.end_value_editing" label="Endstand" :error="$errors->first('cost.end_value_editing')"
                        >
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="cost.end_value_editing" id="cost-detail-cost.end_value_editing" placeholder="0" />
                        </x-input.group>  
                    </div>
                @endif
               
                @if ($cost->costtype !=null && $cost->costtype_id != 'BRK')
                    <!-- Haushaltsnah-->  
                    <div>
                        <x-input.group
                        class="my-2 " paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="cost.haushaltsnah" label="Haushaltsnah" :error="$errors->first('cost.haushaltsnah')">
                            <div class="flex items-center justify-between h-10 sm:h-8">
                                <div class="pl-1">
                                    <x-input.checkbox wire:model="cost.haushaltsnah"></x-input.checkbox>
                                </div>
                            </div>
                        </x-input.group>
                    </div>
                @endif
                
                @if ($cost->need_costkey)
                <!-- Umlageschlüssel--> 
                <div>
                    <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="costkey_id" label="Umlageschlüssel" :error="$errors->first('cost.costkey_id')"
                        x-data
                        x-init="$refs.inputcostkey.focus()"
                        >
                        <x-input.select
                        x-ref="inputcostkey"
                        class="h-10 border-b bg-sky-50 sm:h-8 focus:border-0 w-full" wire:model="cost.costkey_id" id="cost-detail-cost.costkey_id" placeholder="Bitte auswählen" value="">
                        @foreach ($this->costkeys as $label)
                        <option class="flex h-10" value="{{ $label->id }}">
                            <span class="">
                                {{ $label->viewText. ' ('. $label->einheit->shortname. ')'   }}
                            </span>
                        </option>
                        @endforeach
                        </x-input.select>
                    </x-input.group>
                </div> 
                @endif
                
                @if ($onlyConsumptionEdit!=true)
                <!-- Bemerkung-->  
                <div>
                    <x-input.group
                    hohe="h-30"
                    hoheLabel="h-30 sm:h-full sm:pt-3"
                    bottom=false for="noticeForNeko" label="Hinweis für Abrechner" :error="$errors->first('cost.noticeForNeko')">
                        <x-input.textarea  wire:model="cost.noticeForNeko" id="cost-detail-cost.noticeForNeko" placeholder="..." />
                    </x-input.group>
                </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button.secondary wire:click="closeModal(false)">Abbrechen</x-button.secondary>

            <x-button.primary type="submit">Speichern</x-button.primary>
        </x-slot>
    </x-modal.dialog>
</form>




    

