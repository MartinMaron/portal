<div class="w-full p-1 sm:px-0 lg:px-0 max-w-7xl verbrauchsUserEmailliste">
    <div class="font-bold text-lg sm:text-2xl my-8 text-center">
       hier können Sie eintragen an welche Emails die unterjährige Informationen versendet werden sollen            
    </div>    
    <div
        x-data="{open:false}"
        x-init="open=true"
    >
        <div class="flex items-center justify-center">
            <button x-on:click="open = !open" class="font-bold hover:text-sky-700 dark:hover:text-slate-800">Bearbeitungshinweise ansehen ...</button>
        </div>
        <div x-show="open" class="">
            <div class="block sm:flex sm:gap-3 my-4">
                <div class="block my-1 sm:basis-1/3 _hinweisheader">
                    <div class="items-center block m-2">
                        <div class="flex justify-start gap-3">
                            <x-icon.fonts.users-add class="fa-md sm:fa-2xl _icon"></x-icon.fonts.users>
                            <span class="_title">Neue Emailadresse hinzufügen</span>
                        </div>
                        <div class="_text">über diesen Button können Sie neue Email eintragen an welche die Verbraucherinformationen übermittelt werden</div>
                    </div>
                </div>
                <div class="block my-1 sm:basis-1/3 _hinweisheader">
                    <div class="items-center block m-2">
                        <div class="flex justify-start gap-3">
                            <x-icon.fonts.pencil class="fa-md sm:fa-2xl _icon"></x-icon.fonts.users>
                            <span class="_title">Emailadresse bearbeiten</span>
                        </div>
                        <div class="_text">über diesen Button können Sie vorhandene Email bearbeiten</div>
                    </div>
                </div>
                <div class="block my-1 sm:basis-1/3 _hinweisheader">
                    <div class="items-center block m-2">
                        <div class="flex justify-start gap-3">
                            <x-icon.fonts.trash class="fa-md sm:fa-2xl _icon"></x-icon.fonts.trash>
                            <span class="_title">Emailadresse löschen</span>
                        </div>
                        <div class="_text">über diesen Button können Sie vorhandene Email löschen</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex mt-4">
            <x-input.search wire:model.debounce.600ms="filter.search"></x-input.search>
        </div>
        @if ($occupants->count()!=0)
            <div class="dark:bg-slate-900 rounded-md pt-1">
                @foreach ($occupants as $occupant)
                    <div class="block border border-b-2 m-1 border-gray-300 dark:border-slate-700 rounded-lg shadow-sm ">
                        <div class="flex items-center justify-between sm:justify-between">
                            {{-- pokazac ostatniego lokatora mieszkania --}}
                            <div class="text-md ml-1">
                                <livewire:user.occupant.occupant-header :occupant='$occupant' key="{{ now() }}"/>
                            </div>
                            <button 
                                wire:click='raise_CreateVerbrauchsinfoUserEmailModal({{$occupant}})'
                                class="">
                                <i class="fa-regular fa-circle-plus text-xl sm:text-3xl m-1 sm:mr-3 text-sky-600" ></i>
                            </button>
                        </div>

                        @forelse ($occupant->verbrauchsinfoUserEmails as $userEmail)
                            @if (!$userEmail->anonym)
                            <div>
                                <livewire:user.realestate.verbrauchsinfo-user-email.listitem  :userEmail='$userEmail' :wire:key="'verbrauchsinfo-user-email-listitem-'.$userEmail->id"  key="{{ now() }}"/>
                            </div>
                            @endif   
                        @endforeach

                    </div>
                @endforeach
            </div>
        @else
            {{-- pokazac komunikat 'brak wierszy' --}}
        @endif
    </div>
    {{-- modyfikacja wiersza modal --}}
    <div class="xs:max-w-xs xs:w-xs">
        <!-- Save Modal -->
        <div>
            <livewire:user.realestate.verbrauchsinfo-user-email.detail :wire:key="'modal-realestate-verbrauchsinfo-user-email-detail'"/>
        </div>
        <div class="">
            <livewire:user.dialog.delete-modal :wire:key="'modal-realestate-verbrauchsinfo-user-email-delete'"/>
        </div>
        <div>
            <livewire:user.dialog.neko-message-box :wire:key="'neko-message-box'"/>
        </div>
    </div>
    {{-- <div class="mt-6 my-5">
        {{ $occupants->onEachSide(2)->links() }}
    </div> --}}
</div>
