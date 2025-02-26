<div class="w-full py-1 mx-auto max-w-7xl mb-14 text-sky-800 dark:text-slate-300">

    <div class="font-bold text-xl sm:text-2xl flex justify-center">
        Ihre Rechnungen
    </div>

    {{-- Bearbeitungshinweise --}}
    <div
        x-data="{open:true}"
        x-init="open=false"

    >
        <div class="flex items-center justify-center ">
            <button x-on:click="open = !open" class="font-bold hover:text-sky-700">Bearbeitungshinweise ansehen ...</button>
        </div>
        <div x-show="open" class="">
            <div class="justify-center block sm:flex sm:gap-3">
                <div class="block my-1 border border-b-2 border-gray-300 rounded-lg shadow-sm sm:basis-1/3 ">
                    <div class="items-center block m-2">
                        <div class="flex justify-start gap-3">
                            <x-icon.fonts.file-download class="fa-md sm:fa-2xl text-sky-700"></x-icon.fonts.file-download>
                            <span class="font-semibold text-gray-900 text-md">Laden Sie Ihre Rechnung herunter</span>
                        </div>
                        <div class="text-xs text-gray-500 line-clamp-4 md:line-clamp-2">über diesen Button können Sie die Rechnung im PDF-Format auf die Festplatte Ihres Computers herunterladen</div>
                    </div>
                </div>
                <div class="block my-1 border border-b-2 border-gray-300 rounded-lg shadow-sm sm:basis-1/3 ">
                    <div class="items-center block m-2">
                        <div class="flex justify-start gap-3">
                            <x-icon.fonts.pdf-download class="fa-md sm:fa-2xl text-sky-700"></x-icon.fonts.pdf-download>
                            <span class="font-semibold text-gray-900 text-md">Rechnungsvorschau</span>
                        </div>
                        <div class="text-xs text-gray-500 line-clamp-4 md:line-clamp-2">über diesen Button können Sie Rechnungsvorschau</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-5">
        <x-input.search wire:model.debounce.600ms="filters.search"></x-input.search>
    </div>

    
    @if($invoices->count()!=0)
    {{-- small Screen --}}    
    <div class="block mt-10 sm:hidden">
        @foreach ($invoices as $invoice)
            <div class="my-3 mx-1 divide-gray-200 rounded-lg shadow-md max-w-1/4 bg-sky-100 dark:bg-slate-900  text-sky-700 dark:text-slate-300">
                <div class="flex items-center justify-around w-full p-2 space-x-6 ">
                    <div class="flex-1 border-sky-100 ">
                        <div class="items-center ">
                            <div class="flex justify-between gap-2 m-auto">
                                <div class="block">
                                    <div class="font-bold pr-2">
                                        {{ $invoice->caption }}
                                    </div>
                                    <div class="flex justify-start">
                                        <div class="pr-2">
                                            vom
                                        </div>
                                        <div class="">
                                            {{ $invoice->create_date_editing}}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 inline-block align-text-bottom pr-2 font-bold text-xl sm:text-2xl ">
                                    {{ $invoice->brutto_betrag }}
                                </div>

                                <div class="mt-5">
                                    <a class="ml-1 mr-3  text-xl sm:text-2xl " href="{{route('user.downloadspacesfile', 'i-'. $invoice->id )}}" >
                                        <x-icon.fonts.file-download class="  hover:text-sky-300"></x-icon.fonts.file-download>
                                    </a>
                                    <a href="{{route('user.showspacesfile', 'i-'. $invoice->id )}}" class="ml-3 mr-1 text-xl sm:text-2xl ">
                                        <x-icon.fonts.pdf-download class="  hover:text-sky-300"></x-icon.fonts.pdf-download>
                                    </a>
                                </div>
                                
                            </div>
                            <div>
                                @if (str_contains($invoice->description,'Wärmedienst') || str_contains($invoice->description,'Miete'))
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-slate-950 text-sm font-medium bg-green-100 dark:bg-slate-500 rounded-full">Miete</span>
                                @endif
                                @if (str_contains($invoice->description,'Heizkostenabrechnung'))
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-slate-950 text-sm font-medium bg-green-100 dark:bg-slate-500 rounded-full">Heizkostenabr</span>
                                @endif
                                @if (str_contains($invoice->description,'Betriebskosten'))
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-slate-950 text-sm font-medium bg-green-100 dark:bg-slate-500 rounded-full">Betriebskostenabr</span>
                                @endif
                                @if (str_contains($invoice->description,'Ablese'))
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-slate-950 text-sm font-medium bg-green-100 dark:bg-slate-500 rounded-full">Ablesung</span>
                                @endif
                                @if (str_contains($invoice->description,'Rauchmelderservice'))
                                <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 dark:text-slate-950 text-sm font-medium bg-green-100 dark:bg-slate-500 rounded-full">RWM Wartung</span>
                            @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        
    
     {{-- BIG Screen --}} 
    <div class="hidden rounded sm:block ">
            <div class="grid justify-around grid-cols-24 py-3 mt-1 md:text-lg font-bold text-center border rounded-t-lg sm:text-xs bg-sky-100 dark:bg-slate-800  border-sky-100 dark:border-slate-900">
                <div class="col-span-2">
                    Nummer
                </div>
                <div class="col-span-2">
                    Datum
                </div>
                <div class="col-span-12">
                    Leistungsarten
                </div>
                <div class="col-span-2">
                    bezahlt
                </div>
                <div class="col-span-2">
                    bezahlt am
                </div>
                <div class="col-span-2">
                    Betrag
                </div>
                <div class="col-span-2">
                    
                </div>
            </div>

            @foreach ($invoices as $invoice)
                <div class="grid justify-around grid-cols-24 pt-2 mt-0.5 text-center sm:text-xs md:text-sm odd:bg-sky-50 dark:odd:bg-slate-900 dark:even:bg-slate-800 even:bg-gray-100-50 dark:text-slate-300">
                    <div class="font-bold col-span-2">
                        {{ $invoice->caption }}
                    </div>
                    <div class="col-span-2">
                        {{ $invoice->create_date_editing }}
                    </div>
                    <div class="col-span-12">
                        <p class="text-left">{{ $invoice->description  }}</p>
                    </div>
                    <div class="col-span-2">
                        <x-icon.fonts.checked :value='$invoice->bezahlt'></x-icon.fonts.checked>
                    </div>
                    <div class="col-span-2">
                        {{ $invoice->bezahlt_am_editing }}
                    </div>
                    <div class="col-span-2">
                        {{ $invoice->brutto_betrag }}
                    </div>
                    <div class="col-span-2">
                        <div class="flex justify-between px-3">
                            <a href="{{route('user.downloadspacesfile', 'i-'. $invoice->id )}}" class="">
                                <x-icon.fonts.file-download class="text-2xl sm:text-xl  hover:text-sky-300"></x-icon.fonts.file-download>
                            </a>
                            <a target="_blank" href="{{route('user.showspacesfile', 'i-'. $invoice->id )}}" class="">
                                <x-icon.fonts.pdf-download class="text-2xl sm:text-xl hover:text-sky-300"></x-icon.fonts.pdf-download>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="items-center justify-center mt-10">
            <span class="px-10">Rechnung nicht gefunden</span>
        </div>
    @endif

</div>
