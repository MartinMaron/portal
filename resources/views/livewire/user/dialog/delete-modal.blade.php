<div class="{{ $showDeleteDialog ? 'visible' : 'invisible' }}">
    <form wire:submit.prevent="delete()">
        <x-modal.dialog class="bg-sky-50" minWidth="640px" maxWidth="800px" wire:model.defer="showDeleteDialog">
            <!-- Dialog Title -->
            <x-slot name="title">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="text-red-800 fa-solid fa-trash-can"></i>
                </div>
                <span class="mx-auto flex items-center justify-center text-center text-red-800 dark:text-red-500">{{$dialogTitle }}</span>
            </x-slot>   
            <!-- Dialog Content -->
            <x-slot name="content">
                <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200" id="modal-title">{{ $dialogMessage}}</h3>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showDeleteDialog', false)">Abbrechen</x-button.secondary>
                <x-button.delete type="submit">Löschen</x-button.delete>
            </x-slot>
        </x-modal.dialog>
    </form>
</div>