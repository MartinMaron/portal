<x-guest-layout>
  <x-slot name="slot">
    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
          KONTAKT
      </h2>
      <img class="w-full py-2 rounded-lg " src="/img/home/Kontakt_gross.jpg" alt="">
      <div class="px-4 py-5 bg-slate-50 sm:rounded-lg sm:p-6">
        <div class="md:grid md:grid-cols-2 md:gap-6">
          <div class="md:col-span-1">
            {{-- <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
            <p class="mt-1 text-sm text-gray-500">This information will be displayed publicly so be careful what you share.</p> --}}

            <div class="et_pb_text_inner"><strong>Ansprechpartner:</strong><p></p>
              <p class="pt-3">Christof Jaskula<br>
              Hans-Willy-Mertens Str. 2<br>
              50858 Köln
          </p>
              <p class="pt-3" >Tel.: +49 (0)2234 9444320</p>
              <p class="pt-3"><a href="mailto:info@e-neko.de">info@e-neko.de</a></p>
              <p class="pt-3">oder benutzen Sie einfach unser Kontaktformular!</p></div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-1">
            <livewire:guest.kontakt />
          </div>
        </div>

    </div>

  </div>
  </x-slot>
</x-guest-layout>
