<x-guest-layout>
    <x-slot name="slot">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="text-red-600  text-xl font-bold pb-6 w-full text-center">
                WICHTIG : WIR ZIEHEN UM!
            </div>
            <div class="pb-3 text-red-600 font-bold w-full text-center">
                Ab dem 01.01.2025 lautet unsere neue Adresse :
            </div>
            <div class="py-1 w-full text-red-600 font-bold text-center">
                Marsdorfer Str. 76
            </div>
            <div class="pb-4 w-full text-red-600 font-bold text-center">
                50858 Köln – Weiden
            </div>
            <div class="w-full">
                <img class="rounded-md" src="/img/home/Slieder-Mitte.jpg" alt="">
            </div>
            <div class="grid gap-6 mt-6 sm:grid-cols-1 md:grid-cols-2">
                    <div class="">
                        <div class="invisible p-3 mx-auto text-3xl text-center text-gray-700 sm:visible">Willkommen
                        </div>
                        <div class="h-12"></div>
                    </div>
                    <div class="pl-2 border-l-2 border-sky-700">
                            <h5 class="text-xl sm:text-md">Willkommen bei uns <span class="text-blue-600 text-bold">eneko</span></h5>
                            <p class="pt-4">Als unser Ziel verstehen wir ein speziell auf Ihre Immobilie abgestimmtes Paket vom Maßnahmen zu erstellen, die eine kostenreduzierte und präzise Erstellung von Abrechnungen ermöglichen. Dies führt vor allem zu einer Verbesserung der Beziehungen zwischen Vermieter und Mieter.</p>
                            <div class="h-12"></div>
                    </div>
                <div class="">
                    <div class="py-4 text-2xl text-sky-800">HEIZKOSTEN</div>
                    <img src="/img/home/heizkosten.jpg" class="object-cover w-full h-48 rounded-lg" />
                    <div class="pt-4">
                        <p>Unser Dienstleistungspaket für die Heizkosten-, Kaltwasser- und Wärmeabrechnung entspricht höchsten
                            Qualitätsansprüchen. Den Anforderungen an Transparenz und Genauigkeit entsprechen wir ebenso wie
                            dem Bedürfnis nach Schnelligkeit und Qualität in der Bearbeitung.<br>
                            <a href="{{ route('guest.heizkostenabrechnung') }}" class="text-blue-700 underline text-bold">HIER MEHR DAZU ...</a></p>
                    </div>
                    <div class="h-12"></div>
                </div>
                <div class="Betriebkosten">
                    <div class="py-4 text-2xl text-sky-800">BETRIEBSKOSTEN</div>
                    <img class="object-cover w-full h-48 rounded-lg" src="/img/home/betriebskosten.jpg"  />
                    <div class="pt-4">
                        <p>Ersparen Sie sich Zeit, Ärger und Arbeit und legen Sie diese Aufgaben in die Hände unserer Fachleute.
                            Einmal in Anspruch genommen, wollen Sie diesen Service nie wieder missen.<br>
                            <a href="{{ route('guest.betriebskostenabrechnung') }}" class="text-blue-700 underline text-bold">HIER MEHR DAZU ...</a></p>
                        </div>
                    <div class="h-12"></div>
                </div>
                <div class="Rauchmelderservice">
                    <div class="py-4 text-2xl text-sky-800">RAUCHMELDERSERVICE</div>
                    <img src="/img/home/Rauchmelderservice2.jpg" class="object-cover w-full h-48 rounded-lg" />
                    <div class="pt-4">
                        <p>Vermieter, Mieter und selbstnutzende Eigentümer haben die Rauchwarnmelder-Pflicht zu beachten.
                            Vermieter und selbstnutzende Eigentümer müssen Rauchwarnmelder in den Wohnungen einbauen und in Betrieb setzen.
                            Wir beraten Sie gerne bei der Umsetzung der seit 31. Dezember 2013 bestehenden Rauchwarnmelder-Pflicht.
                            Die fachgerechte Montage gehört selbstverständlich mit zu unserem Service..<br>
                            <a href="{{ route('guest.rauchmelderservice') }}" class="text-blue-700 underline text-bold">HIER MEHR DAZU ...</a></p>
                    </div>
                    <div class="h-12"></div>
                </div>
                <div class="energieausweis">
                    <div class="py-4 text-2xl text-sky-800">ENERGIEAUSWEIS</div>
                    <img src="/img/home/energieausweis.jpg" class="object-cover w-full h-48 rounded-lg" />
                    <div class="pt-4">
                        <p>Unser Dienstleistungspaket für die Heizkosten-, Kaltwasser- und Wärmeabrechnung entspricht höchsten
                            Qualitätsansprüchen. Den Anforderungen an Transparenz und Genauigkeit entsprechen wir ebenso wie
                            dem Bedürfnis nach Schnelligkeit und Qualität in der Bearbeitung.<br>
                            <a href="{{ route('guest.energieausweis') }}" class="text-blue-700 underline text-bold">HIER MEHR DAZU ...</a></p>
                    </div>
                    <div class="h-12"></div>
                </div>
            </div>

            <div class="grid gap-10 xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
                <div class="flex justify-center">
                    <img class="rounded-lg" src="/img/home/Quali_1.png" alt="">
                </div>
                <div class="flex justify-center">
                    <img class="rounded-lg" src="/img/home/Quali_2.png" alt="">
                </div>
                <div class="flex justify-center">
                    <img class="rounded-lg" src="/img/home/Quali_3.png" alt="">
                </div>
                <div class="flex justify-center">
                    <img class="rounded-lg" src="/img/home/Quali_4.png" alt="">
                </div>
                <div class="flex justify-center">
                    <img class="rounded-lg" src="/img/home/Quali_5.png" alt="">
                </div>
                <div class="flex justify-center">
                    <img class="rounded-lg" src="/img/home/Quali_6.png" alt="">
                </div>
            </div>
        </div>
        <div class="h-72">
        </div>

    </x-slot>
</x-guest-layout>
