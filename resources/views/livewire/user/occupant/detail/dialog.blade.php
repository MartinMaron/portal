
<div>
    
    <!-- Save Nutzer Bearbeiten -->
    <form wire:submit.prevent="closeModal(true)">
        
        <x-modal.dialog class=" bg-sky-50" minWidth="680px" maxWidth="800px" wire:model="showEditModal">
            <x-slot name="title">
                {{-- <div class="">
                    {{ $current  }}
                </div> --}}
                <div class="text-lg font-bold text-sky-800 dark:text-gray-300 ">
                    <div class="flex border-b-2 dark:border-slate-800">
                        @if ($this->hasLeerstand)
                            <div class="text-lg ">Leerstand</div> 
                        @else
                            @if ($current->nachname)
                                <div class="">{{$current->nachname.' '.$current->vorname}}</div> <x-icon.fonts.pen-line class="h-6 pl-10 mt-1 " ></x-icon.fonts.pen-line>
                            @else
                                <div class="">{{$current->nachname }}</div> <x-icon.fonts.pen-line class="h-6 pl-10 mt-1 " ></x-icon.fonts.pen-line>
                            @endif
                        @endif
                    </div>

                    <div class="px-0 mt-2">
                        <h3 class="text-lg leading-6 ">{{ $pages[$currentPage]['heading'] }}</h3>
                        <p class="mt-1 text-sm font-medium">{{ $pages[$currentPage]['subheading'] }}</p>
                    </div>
                </div>
            </x-slot>
            <!-- Dialog Content -->
            <x-slot name="content">
                <div class="{{ $dialogMode == 'change' ? 'occu-h-600 sm:occu-h-400' : 'occu-h-500 sm:occu-h-300' }} ">

                @if ($errors->isNotEmpty())
                    <div class="block error-box">
                        <span class="block sm:block"><strong class="font-bold">Oops! einige Informationen fehlen oder sind nicht korrekt. </strong>
                            @foreach ($errors->all() as $error)
                                <span class="block sm:block">- {{ $error  }}</span>
                            @endforeach
                        </span>
                    </div>
                @endif


                @if ($currentPage === 1)
                    @if ($dialogMode == 'change')
                        <div class="block p-2 mb-4 text-sm sm:flex sm:justify-between sm:items-center border-2 rounded">
                            <div class="block">
                                <div class="">Leerstand</div>
                                <x-input.group
                                class="my-2 " labelless="true" paddingLabel="" borderless="true" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                                for="leerstand" label="Leerstand" :error="$errors->first('current.leerstand')">

                                    <div class="flex items-center justify-between h-10 sm:h-8">
                                        <div class="pl-1 basis-2/5">
                                            <x-input.checkbox wire:model="hasLeerstand"></x-input.checkbox>
                                        </div>
                                    </div>
                                </x-input.group>
                            </div>

                            <div class="block">
                                <div class="">{{ $hasLeerstand ? 'Leerstand seit:' : 'neuer Nutzer seit:' }}</div>
                                <x-input.group
                                class="my-1" errorDirection="text-left"
                                labelless="true" paddingLabel="" borderless="true" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                                for="dateFrom" label="Zeitraum"
                                >
                                    <div class="flex items-end justify-between h-10 sm:h-8">
                                        <x-input.date class="w-28"
                                            wire:model.lazy="dateFromNewOccupant"
                                            type="text"
                                            id="" >
                                        </x-input.date>
                                    </div>
                                </x-input.group>
                            </div>
                            

                            
                           {{--  <div class="">
                                <div class="">{{ $hasLeerstand ? 'Leerstand seit:' : 'neuer Nutzer seit:' }}</div>
                                <x-input.date class="w-28"
                                wire:model.lazy="dateFromNewOccupant"
                                type="text"
                                :error="$errors->first('dateFromNewOccupant')"
                                id="" >
                                </x-input.date>
                            </div> --}}
                        </div>
                    @else
                        <!-- Zeitraum -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="dateFrom" label="seit">
                            <div class="flex items-end justify-between h-10 sm:h-8">
                                <x-input.date
                                    wire:model.lazy="current.date_from_editing"
                                    type="text"
                                    id="dialog.dateFrom"
                                    disabled="{{$current->nekoId !='new'}}"
                                    >
                                </x-input.date>
                            </div>
                        </x-input.group>
                    
                    @endif

                    @if ($hasLeerstand != true)
                  
                        <!-- Anrede -->
                        <x-input.group
                                class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                                for="anrede" label="Anrede" :error="$errors->first('current.anrede')"
                                x-data
                                x-init="$refs.inputAnrede.focus()"
                                >
                            <x-input.select
                                x-ref="inputAnrede"
                                class="h-10 border-b bg-sky-50 sm:h-8 focus:border-0" wire:model="current.anrede" id="anrede" placeholder="Bitte auswählen" value="">
                                @foreach ($this->salutations as $label)
                                    <option class="h-10" value="{{ $label->bezeichnung }}">
                                        {{ $label->bezeichnung }}
                                    </option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                        <!-- Vorname -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="vorname" label="Vorname" :error="$errors->first('current.vorname')">
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.vorname" id="vorname" placeholder="..." />
                        </x-input.group>
                        <!-- Nachname -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10" hoheOnError="h-26 sm:h-13" 
                        for="nachname" label="Nachname" :error="$errors->first('current.nachname')">
                            <div class="w-full" x-data x-on:focus="$el.select()" >
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.nachname" id="nachname" placeholder="..." />
                            </div>
                        </x-input.group>
                        <!-- E-mail -->
                        <x-input.group
                            class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                            for="email" label="E-mail" :error="$errors->first('current.email')">
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.email" id="email" placeholder="..." />
                        </x-input.group>
                        <!-- Telefonnummer -->
                        <x-input.group
                            class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                            for="telephone_number" label="Telefonnummer" :error="$errors->first('current.telephone_number')">
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.telephone_number" id="telephone_number" placeholder="..." />
                        </x-input.group>
                    @endif 
                            
                @elseif ($currentPage === 2)
                    <!-- Street Hnr-->
                    <x-input.group
                    class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                    for="street" label="Strasse / Hnr">
                        <div class="flex w-full gap-2 h-10 sm:h-8">
                            <div class="h-full basis-5/6">
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.street" id="street" placeholder="..." />
                            </div>
                            <div class="h-full basis-1/6">
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.houseNr" id="houseNr" placeholder="..." />
                            </div>
                        </div>
                    </x-input.group>
                    <!-- PLZ Ort-->
                    <x-input.group
                    class="my-1" paddingLabel="" hoheLabel="h-6  sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                    for="city" label="PLZ / Ort">
                        <div class="flex w-full h-10 gap-2 sm:h-8">
                            <div class="basis-1/5">
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.postcode" id="postcode" placeholder="..." />
                            </div>
                            <div class="basis-4/5">
                                <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.city" id="city" placeholder="..." />
                            </div>
                        </div>
                    </x-input.group>
                    <!-- Adresse -->
                    <x-input.group
                        hohe="h-30"
                        hoheLabel="h-30 sm:h-full sm:pt-3"
                        bottom=true for="address" label="Adresse" :error="$errors->first('current.address')">
                        <x-input.textarea wire:model.lazy="current.address" id="address" placeholder="Nur angeben falls abweichende Anschrift verwendet werden soll." />
                    </x-input.group>                
                @elseif ($currentPage === 3)
                    <!-- Wohnungsdaten-->
                    <div class="mt-3">
                    <!-- Umlageausfallwagnis-->
                        <x-input.group
                        class="my-2 " paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="uaw" label="zusätzliche Belastungen" :error="$errors->first('current.uaw')">

                            <div class="flex items-center justify-between h-10 sm:h-8 w-full">
                                <div class="pl-1 basis-1/2 w-full">
                                    <x-input.checkbox wire:model="current.vat">MwSt</x-input.checkbox>
                                </div>
                                <div class="basis-1/2 w-full">
                                    <x-input.checkbox wire:model="current.uaw">Umlageausfallwag.</x-input.checkbox>
                                </div>
                            </div>
                        </x-input.group>

                        <!-- Fläche und Personen -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="qmkc_editing" label="Fläche / Personenzahl" :error="$errors->first('current.qmkc')">
                            <div class="flex flex-row h-10 sm:h-8 w-full">
                                <div class="basis-1/2 w-full">
                                    <x-input.text class="h-10 rounded bg-sky-50 sm:h-8" wire:model.lazy="current.qmkc_editing" id="dialog.qmkc" placeholder="Heizfläche in m²" />
                                </div>
                                <div class="basis-1/2 w-full">
                                    <x-input.text class="h-10 rounded bg-sky-50 sm:h-8" wire:model.lazy="current.personen_zahl" id="dialog.pe" placeholder="Personenanzahl" />
                                </div>
                            </div>
                        </x-input.group>
                        <!-- Lage u. Wohnungsart -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="lage" label="Lage u. Lokalart">
                            <div class="flex items-center gap-1 justify-items-start h-10 sm:h-8 w-full">
                                <div class="basis 1/2 w-full">
                                    <livewire:lage-autocomplete :search='$current->lage'/>
                                </div>
                                <div class="basis 1/2 w-full">
                                    <x-input.select
                                    wire:model.lazy="current.lokalart"
                                    placeholder="Lokalart"
                                    :error="$errors->first('current.lokalart')" 
                                    >
                                    @if ($unitUsageTypes)
                                        @foreach ($unitUsageTypes as $dsi)
                                            <option class="" value="{{ $dsi->type_id }}">{{ $dsi['caption'] }}</option>
                                        @endforeach
                                    @endif 
                                    </x-input.select>
                                </div>
                            </div>
                        </x-input.group>
                        <!-- Vorauszahlung -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="vorauszahlung" label="Vorauszahlung" :error="$errors->first('current.vorauszahlung_editing')">
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model.lazy="current.vorauszahlung_editing" id="dialog.vorauszahlung" placeholder="0,00" />
                        </x-input.group>
                        <!-- eigene Wohnungsbezeichnung -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="customEinheitNo" label="interne Wohnungnummer" :error="$errors->first('current.customEinheitNo')">
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model="current.customEinheitNo" id="customEinheitNo" placeholder="interne Wohnungnummer" />
                        </x-input.group>
                        <!-- eigentumer Wohnungsbezeichnung -->
                        <x-input.group
                        class="my-1" paddingLabel="" hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10"
                        for="eigentumer" label="Eigentümer" :error="$errors->first('current.eigentumer')">
                            <x-input.text class="h-10 bg-sky-50 sm:h-8" wire:model="current.eigentumer" id="eigentumer" placeholder="Name des Eigentümers bei WEG-Verwaltung" />
                        </x-input.group>
                    </div>


                @elseif ($currentPage === 4)
                    <div class="mt-1 mb-4 sm:mt-2">
                        <x-input.group
                            hohe="h-30"
                            hoheLabel="h-30 sm:h-full sm:pt-3"
                            bottom=false for="bemerkung" label="Bemerkung" :error="$errors->first('current.bemerkung')">
                            <x-input.textarea  wire:model="current.bemerkung" id="bemerkung" placeholder="..." />
                        </x-input.group>
                    </div>
                @endif
                </div>
                      
            </x-slot>

            <x-slot name="footer">
                <div class="">
                    @if ($currentPage === 1)
                        <div></div>
                    @else
                        <x-button.secondary class="mr-3" wire:click="goToPreviousPage">Zurück</x-button.secondary>
                    @endif

                    @if ($currentPage === count($pages))
                        <x-button.primary type="submit">Speichern</x-button.primary> 
                    @else
                        <x-button.primary wire:click="goToNextPage">weiter</x-button.secondary>
                    @endif
                </div>



               {{--  <x-button.secondary wire:click="$set('showEditModal', false)">Abbrechen</x-button.secondary>

                <x-button.primary type="submit">Speichern</x-button.primary> --}}
            </x-slot>
    </x-modal.dialog>
    </form>
</div>
