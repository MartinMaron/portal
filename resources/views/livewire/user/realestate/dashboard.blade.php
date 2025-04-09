<div>
    <div class="grid grid-cols-1 mt-4 gap-4 sm:grid-cols-2 realestateheader">
        @if ($realestate->nutzerlisteactive)
            <div class="relative flex items-center _element">
                <div class="flex-shrink-0">
                    <x-icon.fonts.users class="text-2xl sm:text-4xl _icon"></x-icon.fonts.users>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{route('user.realestateOccupantList', $realestate)}}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="_header">NUTZERLISTE</p>
                        <p class="_text line-clamp-4 md:line-clamp-2">Hier können Sie den Nutzerwechsel durchführen, Vorauszahlungen eintragen, Personenzahl oder Flächen ändern</p>
                        <p class="{{ $realestate->abrechnungssetting->nutzerlisteDone ? 'block text-green-800 dark:text-green-500 font-semibold' : 'hidden'}}">ist bereitgestellt</p>
                    </a>
                </div>
                <div class="flex-shrink-0 {{ $realestate->abrechnungssetting->nutzerlisteDone ? 'block text-green-800 font-semibold' : 'hidden'}}">
                    <i class="fa-solid fa-check text-2xl sm:text-4xl text-green-500 hover:text-sky-300"></i>
                </div>
            </div>
        @endif
        @if ($realestate->uviactive)
            <div class="relative flex items-center px-6 py-5 space-x-3 _element">
                <div class="flex-shrink-0">
                    <x-icon.fonts.poll-people class="text-2xl sm:text-4xl _icon"></x-icon.fonts.poll-people>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{route('user.realestateVerbrauchsinfoUserEmails', $realestate)}}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="_header">VERSAND VERBRAUCHERINFORMATIONEN</p>
                        <p class="_text line-clamp-4 md:line-clamp-2">Hier bestimmen Sie wer die Verbraucherinformationen einsehen kann</p>
                    </a>
                </div>
            </div>
        @endif
        @if ($realestate->kosteneingabe)
            <div class="relative flex items-center px-6 py-5 space-x-3 _element">
                <div class="flex-shrink-0">
                    <x-icon.fonts.file-signature class="text-2xl sm:text-4xl _icon"></x-icon.fonts.file-signature>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{route('user.costs', $realestate)}}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="_header">BRENNSTOFFKOSTEN</p>
                        <p class="_text text-md line-clamp-4 md:line-clamp-2">Hier können Sie die Kosten eintragen und diese Bearbeiten</p>
                        <p class="{{ $realestate->abrechnungssetting->brennstofflisteDone ? 'block text-green-800 font-semibold' : 'hidden'}}">ist bereitgestellt</p>
                    </a>
                </div>
                <div class="flex-shrink-0 {{ $realestate->abrechnungssetting->brennstofflisteDone ? 'block text-green-800 font-semibold' : 'hidden'}}">
                    <i class="fa-solid fa-check text-2xl sm:text-4xl text-green-500 hover:text-sky-300"></i>
                </div>
            </div>
            <div class="relative flex items-center px-6 py-5 space-x-3 _element">
                <div class="flex-shrink-0">
                    <i class="fa-duotone fa-solid fa-file-pen text-2xl sm:text-4xl _icon"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{route('user.heizkostenliste', $realestate)}}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="_header ">WEITERE HEIZKOSTEN</p>
                        <p class="_text line-clamp-4 md:line-clamp-2">Hier können Sie die Kosten eintragen und diese Bearbeiten</p>
                        <p class="{{ $realestate->abrechnungssetting->heizkostenlisteDone ? 'block text-green-800 font-semibold' : 'hidden'}}">ist bereitgestellt</p>
                    </a>
                </div>
                <div class="flex-shrink-0 {{ $realestate->abrechnungssetting->heizkostenlisteDone ? 'block text-green-800 font-semibold' : 'hidden'}}">
                    <i class="fa-solid fa-check text-2xl sm:text-4xl text-green-500 hover:text-sky-300"></i>
                </div>
            </div>
            @if ($realestate->betriebskosten)
            <div class="relative flex items-center px-6 py-5 space-x-3 _element">
                <div class="flex-shrink-0">
                    <i class="fa-regular fa-file-signature text-2xl sm:text-4xl _icon"></i>                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{route('user.betriebskostenliste', $realestate)}}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="_header">BETRIEBSKOSTEN</p>
                        <p class="_text line-clamp-4 md:line-clamp-2">Hier können Sie die Kosten eintragen und diese Bearbeiten</p>
                        <p class="{{ $realestate->abrechnungssetting->betreibskostenDone ? 'block text-green-800 font-semibold' : 'hidden'}}">ist bereitgestellt</p>
                    </a>
                </div>
                <div class="flex-shrink-0 {{ $realestate->abrechnungssetting->betreibskostenDone ? 'block text-green-800 font-semibold' : 'hidden'}}">
                    <i class="fa-solid fa-check text-2xl sm:text-4xl text-green-500"></i>
                </div>
            </div>
                @endif
        @endif

        <div class="relative flex items-center px-6 py-5 space-x-3 _element">
            <div class="flex-shrink-0">
                <x-icon.fonts.pdf-download class="text-2xl sm:text-4xl _icon"></x-icon.fonts.pdf-download>
            </div>
            <div class="flex-1 min-w-0">
                <a href="{{route('user.invoicesList', $realestate)}}" class="focus:outline-none">

                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="_header">RECHUNGSÜBERSICHT</p>
                    <p class="_text line-clamp-4 md:line-clamp-2">Hier können Sie Rechnungen und Dokumente im pdf-Format herunterladen</p>
                </a>
            </div>
        </div>
    </div>
    {{-- falls es eine Abrechnung gibt wird diese angezeigt --}}
    @if ($this->getAbrechnungForDownload() != null )

        <div class="relative flex items-center px-6 py-5 space-x-3 realestateheader">
            <div class="flex-1 min-w-0 px-6 py-5 space-x-3 bg-white dark:bg-slate-500 border-2 dark:border-slate-900 border-gray-300 rounded-lg shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 ">
                <div class="">
                    <div class="block sm:flex sm:justify-center">
                        <div class="_header line-clamp-4 md:line-clamp-2 text-center sm:mb-4 px-2 sm:pr-2 sm:pl-0">
                            {{ 'ABRECHNUNG' }}
                        </div>
                        @if ($this->getLastDoneAbrechnung() != null && $this->getLastDoneAbrechnung()->id != $realestate->abrechnungssetting_id)
                            <div class="_header line-clamp-4 text-center md:line-clamp-2 px-2 sm:pr-2 sm:pl-0">
                                {{ $this->getAbrechnungForDownload()->period_from_editing. '-'. $this->getAbrechnungForDownload()->period_from_editing }}
                            </div>
                        @endif
                        <div class="_header line-clamp-4 md:line-clamp-2 text-center sm:mb-4 px-2 mb-2 sm:pr-2 sm:pl-0">
                            {{ 'herunterladen' }}
                        </div>
                    </div>


                    <div class="block sm:flex sm:justify-between sm:gap-14 sm:mb-6">
                        <a href="{{route('user.downloadspacesfile', 'abrhk_nutzer+'. $this->getAbrechnungForDownload()->id )}}" class="flex justify-start mb-2 items-center">
                            <x-icon.fonts.pdf-download class="text-xl sm:text-xl _icon "></x-icon.fonts.pdf-download>
                            <div class="ml-1">Nutzerabrechnung</div>
                        </a>
                        <a href="{{route('user.downloadspacesfile', 'abrhk_gesamt+'. $this->getAbrechnungForDownload()->id )}}" class="flex justify-start mb-2">
                            <x-icon.fonts.pdf-download class="text-xl sm:text-xl _icon"></x-icon.fonts.pdf-download>
                            <div class="ml-1">Gesamtabrechnung</div>
                        </a>
                        <a href="{{route('user.downloadspacesfile', 'abrhk_kosten+'. $this->getAbrechnungForDownload()->id )}}" class="flex justify-start mb-2">
                            <x-icon.fonts.pdf-download class="text-xl sm:text-xl _icon"></x-icon.fonts.pdf-download>
                            <div class="ml-1">Kostenübersicht</div>
                        </a>
                        <a href="{{route('user.downloadspacesfile', 'abrbk+'. $this->getAbrechnungForDownload()->id )}}" class="flex justify-start mb-2">
                            <x-icon.fonts.pdf-download class="text-xl sm:text-xl _icon"></x-icon.fonts.pdf-download>
                            <div class="ml-1">Betriebskostenabrechnung</div>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    @endif
</div>
