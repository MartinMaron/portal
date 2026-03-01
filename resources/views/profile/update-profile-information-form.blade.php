<x-jet-form-section  submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Kundendaten') }}
    </x-slot>

    <x-slot name="description">
        {{ __('aktualisieren Sie hier Ihren Namen oder die Emailadresse.') }}
    </x-slot>

    <x-slot name="form" >
       

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4 dark:bg-slate-600">
            <x-jet-label class="dark:bg-slate-600" for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full dark:bg-slate-600" wire:model="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4" >
            <x-jet-label for="email" value="{{ __('Anmeldename') }}" />
            <x-jet-input  id="email" type="email" disabled='true' class="mt-1 block w-full" wire:model="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

         <!-- Send Info Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="send_info_email" value="{{ __('Informationen zur Abrechnung an Email versenden') }}" />
            <x-jet-input id="send_info_email" type="text" class="mt-1 block w-full" wire:model="state.send_info_email" autocomplete="send_info_email" />
            <x-jet-input-error for="send_info_email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('speichern') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
