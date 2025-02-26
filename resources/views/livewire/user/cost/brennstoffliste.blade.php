<div>
    <!-- Main -->
    <div class="max-w-7xl w-full mx-auto mb-28">
        <div class="flex items-center mt-3">
            <div class="basis-1/4"></div>
            <div class="basis-2/4 page-title">
                <div class="">BRENNSTOFFKOSTEN</div>
                @if ($this->realestate->abrechnungssetting->brennstofflisteDone)
                    <div class="text-sm">Daten für ausgewählten Abrechnungszeitraum bereits an neko versendet !</div>
                @endif
                @if ($this->nekoerrors)
                    @forelse ($nekoerrors as $nerror)
                        <div class="text-red-700 text-lg">{{ $nerror }} </div>
                    @empty
                    @endforelse
                @endif
            </div>
            <div class="basis-1/4 flex justify-end" wire:click="setDone()">
                @if (! $this->realestate->abrechnungssetting->brennstofflisteDone)
                    <x-button.complete-abr></x-button.complete-abr>
                @endif
            </div>
        </div>
        <!-- Einstellungen -->
        <div class="mt-4 py-3 border-2 text-sky-800 dark:text-gray-200 border-sky-800 dark:border-gray-700 bg-sky-50 dark:bg-slate-800 rounded-md shadow">
            <div  x-data="{ open: false }">
                <div class="flex justify-between">
                    <button x-on:click="open = ! open"
                        class="flex items-end justify-items-end w-full font-bold text-2xl px-3 py-1"
                        >
                            <span x-show="!open" aria-hidden="true" class="mr-2 mb-1 text-xl"><i class="fa-solid fa-caret-right"></i></span>
                            <span x-show="open" aria-hidden="true" class="mr-2 mb-1 text-xl"><i class="fa-solid fa-caret-down"></i></span>
                            <div class="flex items-end content-end">
                                <h2 class="text-xl mb-1 pr-1 font-extrabold tracking-widest">Einstellungen</h2>
                                <div x-show="!open"  class ="flex-1 mb-1-2 text-gray-500 dark:text-gray-200 text-left text-sm line-clamp-1 italic font-extralight" >Kosteneingabe, Bankverbindung, Heizstromberechnung etc. </div>
                            </div>
                    </button>
                </div>
                <div x-show="open">
                   <div class="mx-0">
                        <livewire:user.realestate.abrechnung.einstellungen :baseobject='$realestate' :wire:key="'modal-realestate-abrechnung-settings-'.$realestate->id"/>
                   </div>
                </div>
            </div>
        </div>
        <!-- Kostenliste -->
        <div class="mt-4 kostenliste">
            <!-- liste der Kostearten -->
            @forelse ($filtered as $cost)
                <div 
                    class="columnheader">
                	<!-- liste der Kostearten. Eingabeüberschriften -->
                    <h2>
                        <!-- Überschrift Brennstoffkosten Summe u. anlage-->
                        <div class="mt-16 py-1 sm:text-sm md:text-sm lg:text-lg">
                            @if ($showEditFields || $cost->costtype_id =='BRK')
                                <div class="flex flex-row items-center justify-start border-b border-gray-400">
                                    <div class="basis-1/3 pl-4">
                                        <span class="">Kostenbezeichnung</span>
                                    </div>
                                    <div class="basis-2/3 py-1 mr-1">
                                        <div class="flex px-2 justify-around gap-2 ">
                                            <div class=" {{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} ">
                                                <span class="{{ $dateInputMode ? 'block' : 'hidden' }}">Datum</span>
                                            </div>
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}  px-2 items-center">
                                                <span class="{{ $this->hasConsumptionByType($cost->costtype_id) ? 'block' : 'hidden' }} ">Verbrauch</span>
                                            </div>
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}">
                                                @if ($cost->co2Tax)
                                                    <span class="" style="white-space: nowrap">CO2-Menge</span>
                                                @endif
                                            </div>
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}">
                                                @if ($cost->co2Tax)
                                                    <span class="" style="white-space: nowrap">CO2-Kosten</span>
                                                @endif
                                            </div>    
                                          
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} ">
                                                <div class="">betrag</div>
                                            </div>
                                            
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'hidden' }} ">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                            @endif
                        </div>
                        <div class="flex justify-between m-0">
                            <div class="flex items-end content-end pl-3">
                                <div class="text-xl mb-1 tracking-widest pr-1">{{ $cost->costtype->caption . '  ('. number_format($this->getCostByType($cost->costtype_id)->pluck('gros')->sum(), 2, ',', '.') . ' €)' }}</div>
                            </div>
                            <button wire:click="raise_AddCostModal({{ $cost }})"
                                tabindex="-1">
                                <i class="fa-regular fa-circle-plus text-3xl m-3 text-sky-600" ></i>
                            </button>
                        </div>
                    </h2>

                    <!-- Kosten -->
                    <div>
                        @forelse ($this->getCostByType($cost->costtype_id) as $singleCost)
                            <!-- Kosten-Eingabe Bereich -->
                            <div key="{{ now() }}" class="{{ $this->hasManyBrennstoffkosten && $singleCost->costtype_id=='BRK' ? 'border-2 border-sky-700 rounded-md m-2': ''}}">
                            <!-- Anfangsbestand -->
                            @if ($singleCost->fueltype_id !=null && $singleCost->fueltype->hasTank)
                                <div class="my-2 m-1 flex flex-row items-center justify-start font-normal text-lg h-10 border-b border-gray-400 ">
                                    <div class="basis-1/3  py-1">
                                        <div class="flex justify-start px-2 items-center ">
                                            <div class="text-lg text-center">
                                                <span class="">{{ 'Anfangsbestand '. $singleCost->caption. ' ['. $singleCost->fueltype->einheit->shortname.']'  }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="basis-2/3 py-1 ">
                                        <div class="flex gap-2 ">
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}">
                                                <div class="{{ $dateInputMode ? 'block' : 'hidden' }} text-lg text-center ">
                                                </div>
                                            </div>
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}">
                                                <div class="{{ $this->hasConsumptionByType($cost->costtype_id) ? 'block' : 'hidden' }} text-center">
                                                    {{ $singleCost->startValueEditing }}
                                                </div>
                                            </div>
                                            
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} ">
                                                <div class=""></div>
                                            </div>
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} ">
                                                <div class=""></div>
                                            </div>

                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} ">
                                                <div class="">
                                                    {{$nettoInputMode ? $singleCost->start_value_amount_net_editing : $singleCost->start_value_amount_gros_editing }}
                                                </div>
                                            </div>
                                            
                                            <div class="{{ $showEditFields ? 'basis-1/6' : 'hidden' }} ">
                                                <div class="">
                                                    {{$nettoInputMode ? $singleCost->start_value_amount_net_editing : $singleCost->start_value_amount_gros_editing }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Kosten-Eingabe -->
                            <div class="flex flex-row {{ $singleCost->costAmounts->count() > 0 && $showEditFields ? 'border-b-2' : 'border-b-0' }} items-center justify-start font-normal text-lg ">
                                @if (!$realestate->abrechnungssetting->brennstofflisteDone || ($singleCost->fueltype_id !=null && $singleCost->fueltype->hasTank))
                                <div class="basis-1/3 py-1 ">
                                    <button wire:click="raise_EditCostModal({{ $singleCost }})"
                                            tabindex="-1"
                                            class="flex py-0.5 w-full rounded-sm hover:bg-sky-300 dark:hover:bg-slate-900 px-2 items-center justify-start ">
                                        <div class="text-lg">
                                            @if ($singleCost->fueltype_id !=null && $singleCost->fueltype->hasTank && !$realestate->abrechnungssetting->brennstofflisteDone)
                                                {{ $singleCost->caption. ' '. 'Eingabe' }}
                                            @else
                                                {{ $singleCost->caption }}
                                            @endif
                                        </div>
                                    </button>
                                </div>
                                @endif
                                @if (!$realestate->abrechnungssetting->brennstofflisteDone)
                                    <div class="basis-2/3 py-1">
                                        <livewire:user.costamount.detail-input :cost='$singleCost' :netto='$nettoInputMode' :inputWithDatum='$dateInputMode' :wire:key="'list-cost-costamountinput-'.$singleCost->id" key="{{ now() }}"/>
                                    </div>
                                @else
                                    <!-- Kosten-Ansicht -->
                                    <div class="basis-2/3"></div>
                                @endif
                            </div>

                            @if (true)
                                <!-- Liste der einzelBeträge -->
                                <div class=" {{ $singleCost->costAmounts->count() > 0  ? 'block  bg-sky-200 dark:bg-slate-900' : 'invisible' }} items-center justify-start font-normal text-lg ">
                                    @if (!$showEditFields && !($singleCost->fueltype_id !=null && $singleCost->fueltype->hasTank))
                                        <div class="w-full pl-2 py-2 dark:bg-slate-800">
                                            <span class="">{{ $singleCost->caption }}</span>
                                        </div>   
                                    @endif    
                                                       
                                    @foreach ($singleCost->costAmounts as $singleCostAmount)
                                        @if ($singleCostAmount->abrechnungssetting_id == $cost->realestate->abrechnungssetting_id && ! $singleCostAmount->startvalue && ! $singleCostAmount->endvalue )
                                            <div class="flex items-center font-light">
                                                <div class="basis-1/3 py-1 ">
                                                    <div class="text-sm pl-2">
                                                         
                                                        @if ($singleCost->fueltype_id !=null && $singleCost->fueltype->hasTank)
                                                            {{ 'Zugang ' }}
                                                        @else
                                                           <span class="">{{ 'Eintrag vom: '. $singleCostAmount->created_at->format('d.m.Y') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="basis-2/3 py-1 ">
                                                    <div class="flex items-center px-2 py-1 justify-around gap-2 text-center md:text-lg">
                                                        <div id="user-costamount-listitem-datum{{ $singleCostAmount->id }}"
                                                            style="-moz-appearance: textfield; margin: 0;"
                                                            class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} {{ $dateInputMode ? 'invisible' : '' }} ">
                                                                <span class="">{{ $singleCostAmount->datum }}</span>
                                                        </div>
                                                        <div id="user-costamount-listitem-consumption{{ $singleCostAmount->id }}"
                                                            style="-moz-appearance: textfield; margin: 0;"
                                                            class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} {{ $singleCost->consumption ? 'block' : 'invisible' }}">
                                                                <span class="">{{ $singleCostAmount->consumption_editing }}</span>
                                                        </div>
                                                        <div id="user-costamount-listitem-co2TaxValue{{ $singleCostAmount->id }}"
                                                            style="-moz-appearance: textfield; margin: 0;"
                                                            class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} "   >
                                                                @if ($singleCost->co2Tax)
                                                                    <span class="">{{ $singleCostAmount->coconsupmtion }}</span>
                                                                @endif
                                                        </div>
                                                        <div id="user-costamount-listitem-haushaltsnah{{ $singleCostAmount->id }}"
                                                            style="-moz-appearance: textfield; margin: 0;"
                                                            class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} "   >
                                                            @if ($singleCost->co2Tax)
                                                                @if($nettoInputMode)
                                                                    <span class="">{{ $singleCostAmount->conetto }}</span>
                                                                @else
                                                                    <span class="">{{ $singleCostAmount->cobrutto }}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div id="user-costamount-listitem-betrag{{ $singleCostAmount->id }}"
                                                            style="-moz-appearance: textfield; margin: 0;"
                                                            class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}"
                                                            >
                                                            @if($nettoInputMode)
                                                                <span class="">{{ $singleCostAmount->netto }}</span>
                                                            @else
                                                            <span class="">{{ $singleCostAmount->brutto }}</span>
                                                            @endif
                                                        </div>

                                                        <div
                                                            class="{{ $showEditFields ? 'basis-1/6' : 'hidden' }}"
                                                        >
                                                            <div
                                                                class="flex">
                                                                <div
                                                                    wire:click="editCostAmountModal({{ $singleCostAmount }})"
                                                                    class="{{ $singleCostAmount->nekoId == 0 ? 'block' : 'hidden'}} border text-center bg-sky-300 dark:bg-slate-600 md:text-md dark:hover:bg-slate-800 hover:bg-sky-500 focus:bg-sky-500 dark:focus:bg-slate-500 focus:ring-indigo-500 py-1 mr-2 m-0 focus:border-indigo-500 w-full sm:text-sm border-sky-600 rounded-md ">
                                                                    <x-icon.fonts.pencil class="text-xs ">
                                                                    </x-icon.fonts.pencil>
                                                                </div>
                                                                <div
                                                                    wire:click="questionDeleteCostAmount({{ $singleCostAmount }})"
                                                                    class="{{ $singleCostAmount->nekoId == 0 ? 'block' : 'hidden'}} border text-center bg-red-300  dark:bg-red-800 md:text-md hover:bg-red-500 focus:bg-sky-500 focus:ring-indigo-500 py-1 ml-2 m-0 focus:border-indigo-500 w-full sm:text-sm border-red-600 rounded-md ">
                                                                    <x-icon.fonts.trash class="text-blue-800 "></x-icon.fonts.trash>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Summenfeld -->
                                <div class="font-semibold {{ $cost->costAmounts->count() > 0 ? 'border-y block dark:bg-slate-900' : 'hidden' }}  items-center justify-start font-normal md:text-lg">
                                    <div class="{{ $singleCost->costtype_id == 'BRK' || $singleCost->costAmounts->count() > 1 ? 'flex px-2 items-center dark:bg-slate-800' : 'hidden' }}">
                                        <div class="basis-1/3 text-left ">
                                            @if ($singleCost->fueltype !=null && $singleCost->fueltype->hasTank)
                                            <div class="">
                                                Zugänge Gesamt
                                            </div> 
                                            @else   
                                                <div class="">
                                                    Gesamtsumme
                                                </div> 
                                            @endif
                                        </div>
                                        <div class="basis-2/3 text-center">
                                            <div class="flex justify-start gap-1 items-center">
                                                <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}"></div>
                                                <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }} "   >
                                                    <span class="py-1 {{ $singleCost->consumption ? 'block' : 'hidden' }} ">{{ $singleCost->consumptionsum}}</span>
                                                </div>
                                                <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}"></div>
                                                <div class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}"></div>
                                                <div
                                                    class="{{ $showEditFields ? 'basis-1/6' : 'basis-1/5' }}"
                                                    >
                                                    @if($nettoInputMode)
                                                        <span class="">{{ $singleCost->netto }}</span>
                                                    @else
                                                        <span class="">{{ $singleCost->brutto }}</span>
                                                    @endif
                                                </div>

                                                <div
                                                    class="{{ $showEditFields ? 'basis-1/6' : 'hidden' }} "
                                                >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <!-- Endstand -->
                            @if ($singleCost->fueltype_id !=null && $singleCost->fueltype->hasTank)
                            <div class="border-b border-gray-400 m-2 gap-2 flex flex-row items-center justify-start font-normal text-lg h-10 ">
                                    <div class="basis-1/3 py-1 px-2 flex justify-start items-center text-lg text-center">
                                        <span class="">{{ 'Endbestand '. $singleCost->caption. ' ['. $singleCost->fueltype->einheit->shortname.']'  }}</span>
                                    </div>
                                    <div class="basis-2/3 py-1 ">
                                        <div class="flex justify-around gap-2 text-lg">
                                            <div class="flex justify-around basis-1/6 items-center ">
                                                <div class="{{ $dateInputMode ? 'block' : 'hidden' }} text-lg text-center ">
                                                    <span class=""></span>
                                                </div>
                                            </div>

                                            <div class="flex justify-around basis-1/6 items-center">
                                                <div class="{{ $this->hasConsumptionByType($singleCost->costtype_id) ? 'block' : 'hidden' }} w-full text-center flex items-center">
                                                    @if ($showEditFields)
                                                        <div 
                                                            wire:click="raise_EditCostConsumptionModal({{ $singleCost }})"                                         
                                                            class="{{ $singleCost->end_value_editing <= '0,0' ? 'bg-red-300 dark:bg-red-600 dark:hover:bg-red-700 md:text-md hover:bg-red-500 focus:bg-red-500' : 'bg-sky-300 dark:bg-slate-900 dark:hover:bg-slate-700 hover:bg-sky-500' }} {{ $showEditFields ? 'block' : 'hidden' }} w-full my-1 border flex justify-around {{ $singleCost->endValue <= 0 ? 'bg-red-300 md:text-md hover:bg-red-500 focus:bg-red-500' : 'hover:bg-sky-300' }} focus:ring-indigo-500 p-1 m-0 focus:border-indigo-500 block sm:text-sm border-gray-900 rounded-md"   
                                                        >
                                                            <span class="md:text-md "><i class="text-left pr-1 fa-solid fa-pencil"></i></i></span>
                                                            @if ($singleCost->end_value_editing <= '0,0')
                                                                <span class="md:text-md text-right">Eingabe</span>
                                                            @else
                                                                <span class="md:text-md text-right">{{ $singleCost->end_value_editing }}</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="">{{ $singleCost->end_value_editing }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex justify-around basis-1/6 items-center "></div>
                                            <div class="flex justify-around basis-1/6 items-center "></div>
                                            <div class="flex {{ $showEditFields ? 'block' : 'hidden' }} justify-around basis-1/6 px-2 items-center "></div>
                                            <div class="flex justify-around basis-1/6 items-center "></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div> 
                        @empty
                            <div class="flex justify-center items-center space-x-2 bg-sky-100">
                                <span class="font-medium py-8 text-cool-gray-400 text-xl">nichts gefunden...</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="flex justify-center items-center space-x-2 bg-sky-100">
                    <span class="font-medium py-8 text-cool-gray-400 text-xl">nichts gefunden...</span>
                </div>
            @endforelse

        </div>
    </div>
    <div class="xs:max-w-xs xs:w-xs">
        <!-- CreateOrEdit Cost Modal -->
        <div>
            <livewire:user.cost.detail :cost='$current' :netAmountInput='$nettoInputMode' :costinvoicingtype="'HZ'" :wire:key="'modal-realestate-cost-detail'"/>
        </div>
        <!-- CreateOrEdit CostAmount Modal -->
        <div>
            <livewire:user.costamount.detail :wire:key="'modal-realestate-costamount-detail'"/>
        </div>
        <!-- for Delete or Confirm -->
        <div>
            <livewire:user.dialog.neko-message-box :wire:key="'neko-message-box'"/>
        </div>
    </div>
</div>



