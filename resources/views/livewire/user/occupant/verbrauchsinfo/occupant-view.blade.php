<div>
    <div class="w-full bg-white dark:bg-slate-800 shadow-md rounded-b-lg">
        @if ($rows->count()!=0)
            @foreach ($rows as $verbrauchsinfo)
            <div class="mt-6 {{ $verbrauchsinfo->ww ? 'border-y-2 border-red-600' : 'border-y-2 border-green-400' }} selection:items-center justify-between w-full p-2 ">
                <div class="flex-1 text-center font-semibold {{ $verbrauchsinfo->ww ? 'text-red-800 dark:text-red-500 ' : 'text-green-600 dark:text-green-700 ' }}  ">
                    {{ $verbrauchsinfo->art. ' im '. $verbrauchsinfo->zeitraum_akt}}
                </div>
                <div class="flex-1 font-semibold text-center dark:text-slate-400">
                    Verbrauchswerte
                </div>
                <div class="grid w-full gap-4 sx:grid-cols-3">
                    <div class="flex justify-between">
                        <div class="">
                            <div class="flex-1 text-sm text-center text-gray-600 dark:text-slate-400 underline"> {{ $verbrauchsinfo->zeitraum_akt}} </div>
                            <div class="flex-1 text-center dark:text-slate-300"> {{ $verbrauchsinfo->verbrauch_akt_display}} </div>
                        </div>
                        <div class="">
                            <div class="flex-1 text-sm text-center text-gray-600 dark:text-slate-400 underline"> {{ $verbrauchsinfo->zeitraum_mon}} </div>
                            <div class="flex-1 text-center dark:text-slate-300"> {{ $verbrauchsinfo->verbrauch_mon_display}} </div>
                         </div>
                        <div class="">
                            <div class="flex-1 text-sm text-center text-gray-600  dark:text-slate-400 underline"> {{ $verbrauchsinfo->zeitraum_vorj}} </div>
                            <div class="flex-1 text-center dark:text-slate-300"> {{ $verbrauchsinfo->verbrauch_vorj_display}} </div>
                          </div>
                    </div>
                </div>
                <div class="flex-1 pt-3 font-semibold text-center dark:text-slate-400">
                    Gebäudedurchschnitt
                </div>

                <div class="flex-1 text-center dark:text-slate-300">
                    {{ $verbrauchsinfo->durchschnitt_display }}
                </div>

            </div>

            @endforeach
            <div class="flex justify-around pb-4">
            <x-button.transparent class="flex-row px-2 py-1 mt-3 bg-sky-100 border-1 border-sky-200" :active="request()->routeIs('user.verbrauchsinfohistory')">
                <a href="{{route('user.occupantVerbrauchsinfos', $occupant)}}">
                    <span class = "font-semibold text-black transition duration-150 text-md opacity-90 group-hover:opacity-100 ease">
                        {{ __('Verlaufsliste') }}
                    </span>
                </a>
            </x-button.transparent>

            <x-button.transparent class="flex-row px-2 py-1 mt-3 bg-sky-100 border-1 border-sky-200" :active="request()->routeIs('user.occupantVerbrauchsinfoCounterMeters')">
                <a href="{{route('user.occupantVerbrauchsinfoCounterMeters', ['occupant_id' => $occupant, 'jahr_monat' => '2023-6'])}}">

                    <span class = "font-semibold text-black transition duration-150 text-md opacity-90 group-hover:opacity-100 ease">

                        {{ __('Zähler anzeigen') }}

                    </span>

                </a>
                </x-button.transparent>
            </div>
        @endif

    </div>

    @if ($rows->count()==0)
        <livewire:not-found />
    @endif



</div>
