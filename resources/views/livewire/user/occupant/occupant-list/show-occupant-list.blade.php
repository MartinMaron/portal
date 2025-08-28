<div class="space-y-4" key="{{ now() }}">
    <div class="flex items-center">
        <div class="xs:none sm:basis-1/4">
        </div>
        <div class="basis-3/4 sm:basis-2/4 page-title">
            <div>NUTZERLISTE</div>
            @if ($this->realestate->abrechnungssetting->nutzerlisteDone)
                <div class="text-sm">Daten für ausgewählten Abrechnungszeitraum bereits an neko versendet !</div>
            @endif
        </div>
        <div class="sm:basis-1/4 flex justify-end" wire:click="setDone()">
            @if (! $this->realestate->abrechnungssetting->nutzerlisteDone)
                <div class="my-2">
                    <x-button.complete-abr></x-button.complete-abr>
                </div>
            @endif
        </div>
    </div>
    <div class="">
        <!-- Suchfeld -->
        <x-input.search wire:model.live.debounce.600ms="filters.search"></x-input.search>
    </div>
    <div class="flex w-full px-5 sm:px-0 gap-2 mb-2 justify-between sm:justify-between">
        @if ($this->hasAnyCustomEinheitNo($realestate))
            <x-input.radio-bool
                wire:model.live="current.occupant_number_mode" wire:change="toggle('nummer')"
                id="user.occupant.occupant-list.show-occupant-list.occupant_nummber_mode"
                aria_label="RadioNummer"
                title="Nummer anzeigen" text_value0="eneko" text_value1="Verwalter"
                >
            </x-input.radio-bool>
        @endif
        @if ($this->hasAnyEigentumer($realestate))
            <x-input.radio-bool
                    wire:model.live="current.occupant_name_mode" wire:change="toggle('eigentumer')"
                    id="user.occupant.occupant-list.show-occupant-list.occupant_name_mode"
                    aria_label="RadioName"
                    title="Nutzer anzeigen" text_value0="Mieter" text_value1="Eigentümer"
                    >
            </x-input.radio-bool>
            
        @endif
        @if ($this->realestate->betriebskosten)
            <x-input.radio-bool
                    wire:model="current.prepaidtype" wire:change="toggle('prepaidtype')"
                    id="user.occupant.occupant-list.show-occupant-list.vorauszahlungen_mode"
                    aria_label="RadioPrepaids"
                    :width='80'
                    title="Vorauszahlungen anzeigen" text_value0="Betriebskosten" text_value1="Heizkosten"
                    value0='B' value1='H'
                    >
            </x-input.radio-bool>
        @endif
        @if ($this->hasVat($realestate))
            <x-input.radio-bool
                    wire:model.live="current.eingabeCostNetto" wire:change="toggle('eingabeCostNetto')"
                    id="user.occupant.occupant-list.show-occupant-list.vat_mode"
                    aria_label="RadioVat"
                    title="Vorauszahlungen bei MwSt. Pflicht" text_value0="brutto" text_value1="netto"
                    >
            </x-input.radio-bool>
        @endif
    </div>

<!-- Big screen Occupants List TABELLA -->
    <div class="hidden sm:block md:max-w-7xl" key="{{ now() }}">
        <x-table class="occu-table" key="{{ now() }}">
            <x-slot name="head">
                <x-table.thead class="">
                @if ($this->rows->count()!=0)
                    <x-table.tr class="">
                        <x-table.th class="w-20 text-left occu-thead-th">
                            Nummer
                        </x-table.th>
                        <x-table.th class="text-left w-30 occu-thead-th sm:visible">Lage</x-table.th>
                        <x-table.th class="text-left w-70 occu-thead-th">
                            @if ($this->realestate->occupant_name_mode == 1)
                                Eigentümer
                            @else
                                Nutzer
                            @endif
                        </x-table.th>
                        <x-table.th class="text-center occu-thead-th">Zeitraum</x-table.th>
                        <x-table.th class="text-center w-30 occu-thead-th">MwSt.</x-table.th>
                        <x-table.th class="text-center w-50 occu-thead-th">m²</x-table.th>
                        <x-table.th class="text-center w-50 occu-thead-th">pe</x-table.th>
                        <x-table.th class="w-40 text-center occu-thead-th">Vorausz.
                        </x-table.th>
                    </x-table.tr>
                @endif

                </x-table.thead>
            </x-slot>
            <x-slot name="body" class="occu-tbl-container">
                <x-table.tbody class="occu-tbody">
                    @forelse ($this->rows as $occupant)
                    <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $occupant->id }}">
                        <x-table.th class="w-20 text-left occu-th" style="display:table-cell !important;">
                            @if ($realestate->occupant_number_mode)
                                <span class="{{ $occupant->customEinheitNo ? 'font-bold' : 'font-thin text-opacity-50' }}">
                                    {{ $occupant->display_einheit }}
                                </span>
                            @else
                                {{ $occupant->NutzerKennnummer }}
                            @endif
                        </x-table.th>
                        <x-table.th class="text-left occu-th w-30">{{ $occupant->lage }}</x-table.th>
                        <x-table.th class="w-full occu-td hover:bg-sky-100 dark:hover:bg-slate-600" style="min-width: 20rem;">
                            <button tabindex="-1" 
                                wire:click="edit({{ $occupant}})"
                                class="w-full text-left" 
                                type="button">
                                @if ($this->realestate->occupant_name_mode == 1)
                                    <span class="{{ $occupant->eigentumer ? 'font-bold' : 'font-thin text-opacity-50' }}">
                                        {{ $occupant->display_eigentumer_name }}
                                    </span>
                                @else
                                    {{ $occupant->vorname . ' '. $occupant->nachname }}
                                @endif
                            </button>
                        </x-table.th>
                        <x-table.td class="text-center occu-td" style="min-width: 14rem; max-width: 14rem">
                            <div class="flex px-2">
                                <span>{{ ($occupant && is_object($occupant)) ? ($occupant->date_from_editing ?? '') : '' }}</span>
                                <span class="w-6">-</span>
                                @if ($occupant->dateTo)
                                    <span>{{ $occupant->date_to_editing }}</span>
                                @else
                                    <div class="w-40 px-auto gap-2 {{ $occupant->canDelete ? 'flex justify-between' : 'flex justify-center' }} items-center mx-1">
                                        <button class="w-18 px-auto border-2 dark:border-slate-600"
                                            tabindex="-1"
                                            style="min-width: 3rem; max-width: 3rem"
                                            wire:click='change({{$occupant}})'>
                                            <x-icon.fonts.user-move
                                            class="text-sky-700 dark:text-slate-800 hover:text-sky-300 dark:hover:text-slate-950 fa-solid fa-house-person-leave">
                                            </x-icon.fonts.user-move>
                                        </button>
                                        @if ($occupant->canDelete)
                                            <button class="w-18 px-auto border-2"
                                            wire:click='emit_QuestionDeleteModal({{$occupant}})'
                                            tabindex="-1"
                                            style="min-width: 3rem; max-width: 3rem"
                                            >
                                            <span >
                                                <x-icon.fonts.trash class="text-red-700 hover:text-red-300 fa-solid "></x-icon.fonts.trash>
                                            </span>
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </x-table.td>
                        <x-table.td class="text-center occu-td w-30">
                            <x-icon.fonts.checked :value='$occupant->vat'></x-icon.fonts.checked>
                        </x-table.td>
                        <x-table.td class="text-center occu-td w-30">
                            <span class="">{{number_format($occupant->qmkc,  2, ',', '.') }}</span>
                        </x-table.td>
                        <x-table.td class="text-center occu-td w-50 " style="min-width: 4rem;">
                            @if ($this->editable)
{{--                                 <livewire:user.occupant.personencount-edit :occupant='$occupant' :wire:key="'user.occupant.personencount-edit-'.$occupant->id" key="{{ now() }}"/> --}}
                                <input     
                                    type="text"
                                    inputmode="numeric" 
                                    wire:model.blur="personCounts.{{ $occupant->id }}"
                                    style="-moz-appearance: textfield; margin: 0;"
                                    class="text-center border dark:text-slate-950 dark:bg-slate-400 md:text-md focus:ring-black p-1 px-2 m-0 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-slate-800 rounded-md"   
                                >
                                @else
                                <span class="text-center">{{$occupant->personen_zahl}}</span>
                            @endif
                        </x-table.td>
                        <x-table.td class="w-40 p-0 text-right occu-td" style="min-width: 7rem; max-width: 7rem">
                            @if ($this->editable)
                                {{-- <livewire:user.occupant.vorauszahlung-edit :occupant='$occupant' :wire:key="'user.occupant.vorauszahlung-edit-'.$occupant->id" key="{{ now() }}"/> --}}
                                <input     
                                    type="text"
                                    inputmode="numeric" 
                                    wire:model.blur="prepaids.{{ $occupant->id }}"
                                    style="-moz-appearance: textfield; margin: 0;"
                                    class="text-center border dark:text-slate-950 dark:bg-slate-400 md:text-md focus:ring-black p-1 px-2 m-0 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-slate-800 rounded-md"   
                                >
                                @else
                                <span class="pr-2 ">{{$occupant->vorauszahlung_editing }}</span>
                            @endif
                        </x-table.td>
                    </x-table.tr>
                    @empty
                    <x-table.tr>
                        <div class="flex items-center justify-center space-x-2 bg-sky-100">
                            <span class="font-medium py-8 text-cool-gray-400 text-xl">nichts gefunden...</span>
                        </div>
                    </x-table.tr>
                    @endforelse
                </x-table.tbody>
            </x-slot>
        </x-table>
    </div>

<!-- Small Screen Occupants List -->
    <div class="block sm:hidden" key="{{ now() }}">
        <div class="grid w-full grid-cols-1 gap-4 mt-6 sm:grid-cols-2 lg:grid-cols-3" key="{{ now() }}">

            @foreach ($this->rows as $occupant)
                <div wire:key="row-{{ $occupant->id }}"
                    class="my-1 mx-1 block divide-gray-200 rounded-lg shadow-md text-sky-700 dark:text-slate-200 bg-sky-50 dark:bg-slate-900" key="{{ now() }}" >

                    <div class="flex my-1 mx-1 justify-between gap-2 m-auto text-lg ">
                        @if ($this->realestate->occupant_number_mode)
                        <span class="{{ $occupant->customEinheitNo ? 'font-bold' : 'font-thin text-opacity-50' }}">
                            {{ $occupant->display_einheit }}
                        </span>
                        @else
                            {{ $occupant->NutzerKennnummer }}
                        @endif
                        <div class="">
                            {{ $occupant->qmkcEditing }} m²
                        </div>
                    </div>

                    <div class="flex mx-1 justify-between text-lg font-semibold">
                        @if ($this->realestate->occupant_name_mode == 1)
                        <span class="{{ $occupant->eigentumer ? 'font-bold' : 'font-thin text-opacity-50' }}">
                            {{ $occupant->display_eigentumer_name }}
                        </span>
                        @else
                            {{ $occupant->vorname . ' '. $occupant->nachname }}
                        @endif
                        <div class="mr-2">
                            <x-jet-dropdown align="right" class="">
                                <x-slot name="trigger">
                                    <button class="px-2 py-1 duration-150 rounded-lg bg-sky-100 dark:bg-slate-700 border-sky-100 text-md dark:text-slate-100 text-sky-700 opacity-90 group-hover:opacity-100 ease">&ctdot;</button>
                                </x-slot>
                                <x-slot name="content" class="">
                                    <x-jet-dropdown-link
                                        class="cursor-pointer"
                                        wire:click='edit({{$occupant}})'
                                        >
                                        <x-icon.fonts.editable-pencil class="text-sm cursor-pointer text-sky-700 hover:text-sky-300"></x-icon.fonts.editable-pencil>
                                        {{ __('Bearbeiten') }}
                                    </x-jet-dropdown-link>

                                    <x-jet-dropdown-link
                                        class="cursor-pointer"
                                        wire:click='change({{$occupant}})'
                                        >
                                        <x-icon.fonts.user-move class="cursor-pointer text-sky-700 hover:text-sky-300 fa-solid fa-house-person-leave"></x-icon.fonts.user-move>
                                        {{ __('Nutzerwechsel') }}
                                    </x-jet-dropdown-link>
                                    @if ($occupant->canDelete)

                                        <x-jet-dropdown-link
                                            class="cursor-pointer"
                                            wire:click='emit_QuestionDeleteModal({{$occupant}})'
                                            >
                                            <x-icon.fonts.trash class="cursor-pointer text-red-700 hover:text-sky-300 fa-solid "></x-icon.fonts.trash>
                                            {{ __('Löschen') }}
                                        </x-jet-dropdown-link>
                                    @endif
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>

                    <div class="flex justify-between mx-1 text-sm">
                        <div class="">
                            {{ $occupant->zeitraumText }}
                        </div>
                        <div class="">
                            {{-- <span class="ml-3">Nutzerwechsel</span> --}}
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
        @if (auth()->user()->isAdmin)
            <div class="bg-slate-500 text-xl m-2 py-3 rounded-md">
                Mitabeiterbereich
            </div>
            {{-- <div>
                <form wire:submit.prevent="uploadPhotoDisc">
                    <input type="file" wire:model="photo" accept="image/*" />
                    <button type="submit" class="bg-blue-500 text-white p-2">Hochladen</button>
                </form>

                @if ($uploadedPhotoUrl)
                    <p>Bild erfolgreich hochgeladen! URL: <a href="{{ $uploadedPhotoUrl }}" target="_blank">{{ $uploadedPhotoUrl }}</a></p>
                @endif
            </div> --}}
            <div x-data="webcamHandler"
            x-init = "initWebcam" >
                <video id="webcam" autoplay class="w-full"></video>
                <canvas id="snapshot" style="display: none;"></canvas>
                <button @click="capturePhoto" class="bg-blue-500 text-white p-2 mt-4">Foto aufnehmen</button>
            </div>
            <div id="reader"></div>
            <div id="result"></div>
            <script>
                function webcamHandler() {
                    return {
                        video: null,
                        canvas: null,
                        context: null,
                        capturePhoto() {
                            alert(this.video)
                            // Foto aufnehmen und an Livewire senden
                            this.canvas.width = this.video.videoWidth;
                            this.canvas.height = this.video.videoHeight;
                            this.context.drawImage(this.video, 0, 0);
                            const imageData = this.canvas.toDataURL('image/png');
                            this.$wire.emit('uploadPhoto', imageData); // Senden an Backend


                        }
                    };
                }

                function initWebcam() {
                    this.video = document.getElementById('webcam')
                    this.canvas = document.getElementById('snapshot');
                    this.context = this.canvas.getContext('2d');

                    navigator.mediaDevices
                            .enumerateDevices()
                            .then((devices) => {
                            devices.forEach((device) => {
                                if (device.label.includes('facing back')) {
                                    const constraints = {
                                        'video': {
                                            'deviceId': device.deviceId,
                                            'width': {'min': 500},
                                            'height': {'min': 500}
                                            }
                                        }
                                    navigator.mediaDevices.getUserMedia(constraints).then(stream => {
                                    this.video.srcObject = stream;
                                    });
                                }
                            });
                            })
                            .catch((err) => {
                            console.error(`${err.name}: ${err.message}`);
                            });



                }

                const scanner = new Html5QrcodeScanner('reader', {
                        qrbox: {
                        width: 250,
                        height: 250,
                        },
                        fps: 20,
                        });
                        scanner.render(success, error);
                        function success(result) {
                        document.getElementById('result').innerHTML = `
                        <h2>Success!</h2>
                        <p><a href="${result}">${result}</a></p>
                        `;
                        scanner.clear();
                        document.getElementById('reader').remove();
                        }
                        function error(err) {
                        console.error(err);
                        }
            </script>
        @endif
    </div>

    <!-- Dialoge -->
    <livewire:user.occupant.detail.dialog :wire:key="'occupant-dialog-refactored'" />
    <livewire:user.dialog.neko-message-box :wire:key="'neko-message-box-refactored'" />

    
    <div class="mt-6 my-5">
        {{ $this->rows->onEachSide(2)->links() }}
    </div>
</div>
