<x-guest-layout>
    <x-slot name="slot">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <h2 class="py-2 text-2xl font-semibold leading-tight text-gray-800">
                WÄRMEZÄHLER
            </h2>
            <img class="w-full py-2 rounded-md " src="/img/home/Waermezaehler_gross.jpg" alt="">
            <p class="pt-3">
                Wärmezähler empfehlen sich für die präzise Messung des Wärmeverbrauchs von Wohnungen und Nutzergruppen innerhalb geschlossener Heiz- und Regelkreise. Platin-Widerstands-Temperaturfühler sorgen für exakte Messungen, hochwertige Werkstoffe für hohe Betriebssicherheit bei den Volumenmessteilen. Individuelle Messung des Wärmeverbrauchs für alle Heizungsanlagen inklusive Niedertemperaturanlagen, Fußboden- und Deckenheizungen, Lufterhitzer etc.
            </p>
            <p class="pt-6">
                <h2 class="text-xl font-semibold" >Supercal 739</h2>
            </p>
            <p class="pt-3">
                <strong class="font-bold text-md" >Hauptmerkmale</strong>
            </p>

            <ul>
                <x-listitem.guest-standard>Einstrahlzähler, Messkapselzähler G2“ und M77x1,5</x-listitem.guest-standard>
                <x-listitem.guest-standard>Wärmezähler, Kältezähler oder kombinierter Wärme/Kältezähler</x-listitem.guest-standard>
                <x-listitem.guest-standard>Abnehmbares Rechenwerk</x-listitem.guest-standard>
                <x-listitem.guest-standard>Der Supercal 739 verfügt über eine grosse Anzahl optionaler Schnittstellen für die Datenfernauslesung : – Optische Schnittstelle, M-Bus mit Speisung via M-Bus Bidirektionaler Funk Sontex Supercom, Wireless M-Bus, OMS, zwei Pulsausgänge.</x-listitem.guest-standard>
                <x-listitem.guest-standard>18 Monatswerte für Wärmeenergie, Volumen, Kälteenergie und zwei zusätzliche Impulseingänge Batterielebensdauer 6+1 oder 12+1 Jahre</x-listitem.guest-standard>
                <x-listitem.guest-standard>Zulassung auch mit asymmetrischem Temperaturfühlereinbau</x-listitem.guest-standard>
                <x-listitem.guest-standard>Einfaches Bedien- und Ablesekonzept</x-listitem.guest-standard>
                <x-listitem.guest-standard>Selbstüberwachung und Fehleranzeige</x-listitem.guest-standard>
                <x-listitem.guest-standard>Software für Inbetriebnahme-Protokoll und Parametrierung</x-listitem.guest-standard>
            </ul>

            <p class="pt-3">Der <strong>Supercal 739</strong> ist ein Kompakt-Wärmezähler für das Messen von Wärme- und Kälte-Energie in einem breiten Anwendungsfeld in der Haustechnik und lässt sich dank der zahlreichen Fernauslese-Schnittstellen einfach in ein Gebäudemanagementsystem oder eine Smart Metering-Umgebung einbinden.</p>
            <p class="pt-3">Der <strong>Supercal 739</strong> ist als Einstrahlzähler und Mehrstrahl-Messkapselzähler für G2″ und M77x1,5 Anschlussstücke in den Durchflüssen qp 0,6; qp 1,5; qp 2,5 m³/h erhältlich.</p>
            <p class="pt-3">Der Kompaktwärmezähler <strong>Supercal 739</strong> erfüllt die Anforderungen der europäischen Messgeräte-Richtlinie MID 2014/32/EU und der Norm EN 1434 Klasse 3.</p>
            <div class="flex">
                <p class="py-2">
                    <strong>weitere Wärmezähler (PDF)</strong>
                </p>

                    <a class="flex py-2 ml-3 underline bg-white" href="{{route('downloadpublicfile', 'Waeremezaehler.pdf')}}">
                        <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                            {{ __('download .pdf') }}
                        </span>
                    </a>

                     <a target="_blank" class="flex py-2 ml-3 underline bg-white" href="{{route('showpublicfile', 'Waeremezaehler.pdf')}}">
                        <span class = "font-semibold transition duration-150 text-md text-sky-900 opacity-90 group-hover:opacity-100 ease">
                            {{ __('ansehen .pdf') }}
                        </span>
                    </a>
            </div>

        </div>
    </x-slot>
</x-guest-layout>
