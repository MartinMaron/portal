<form wire:submit.prevent="closeModal(true)">
    <x-modal.dialog class="bg-sky-50"
           wire:model="showEditModal">
        <!-- Dialog Title -->
        <x-slot name="title">
            <div class="flex flex-row justify-between">
                <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-full bg-sky-100">
                    {{-- <i class="text-sky-800 fa-solid fa-trash-can"></i> --}}
                    <x-icon.fonts.pencil class="px-2 text-xs text-sky-500 hover:text-sky-800 ">
                    </x-icon.fonts.pencil>
                </div>
            </div>
        </x-slot>
        <!-- Dialog Content -->
        <x-slot name="content">
            <div>
                <x-input.group
                    class="border-0" for="userEmail.firstinitUsername" label="Username für Webaccount" :error="$errors->first('userEmail.firstinitUsername')"
                    hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10">
                    <x-input.text class="bg-sky-50 sm:h-8" wire:model.lazy="userEmail.firstinitUsername" id="userEmail.firstinitUsername" />
                </x-input.group>
                <x-input.group
                    class="border-0" for="userEmail.email" label="Email" :error="$errors->first('userEmail.email')"
                    hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10">
                    <x-input.text class="bg-sky-50 sm:h-8" wire:model.lazy="userEmail.email" id="userEmail.email" />
                </x-input.group>
                <x-input.group
                class="border-0" for="userEmail.infoPerPortal" label="Per Portal" :error="$errors->first('userEmail.infoPerPortal')"
                hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10">
                    <div class="flex items-center justify-between h-10 sm:h-8">
                        <div class="pl-1">
                            <x-input.checkbox wire:model="userEmail.infoPerPortal"></x-input.checkbox>
                        </div>
                    </div>
                </x-input.group>
                <x-input.group
                class="border-0" for="userEmail.infoPerEmail" label="Per Email" :error="$errors->first('userEmail.infoPerEmail')"
                hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10">
                    <div class="flex items-center justify-between h-10 sm:h-8">
                        <div class="pl-1">
                            <x-input.checkbox wire:model="userEmail.infoPerEmail"></x-input.checkbox>
                        </div>
                    </div>
                </x-input.group>
                <x-input.group
                class="border-0" for="userEmail.infoPerPost" label="Per Post" :error="$errors->first('userEmail.infoPerPost')"
                hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10">
                    <div class="flex items-center justify-between h-10 sm:h-8">
                        <div class="pl-1">
                            <x-input.checkbox wire:model="userEmail.infoPerPost"></x-input.checkbox>
                        </div>
                    </div>
                </x-input.group>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary wire:click="closeModal(false)">Abbrechen</x-button.secondary>
            <x-button.delete type="submit">Speichern</x-button.delete>
        </x-slot>
    </x-modal.dialog>
</form>


















