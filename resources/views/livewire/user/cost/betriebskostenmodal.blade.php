<form wire:submit="closeModal(true)">
    <x-modal.dialog class="bg-sky-50"
           wire:model.live="showEditModal">
        <!-- Dialog Title -->
        <x-slot name="title">

            @if($dialogMode != 'init')
                <div class="flex">
                    @if ($current['caption'])
                        <div class="text-lg font-bold text-sky-500 dark:text-slate-300">{{ $current['caption'] }}</div> <x-icon.fonts.pen-line class="text-sky-500 dark:text-red-300 pl-10 h-6 mt-1" ></x-icon.fonts.pen-line>
                    @else
                        <div class="text-lg font-bold text-sky-500 dark:text-slate-300">Neu</div> <x-icon.fonts.pen-line class="text-sky-500 dark:text-slate-300 pl-10 h-6 mt-1" ></x-icon.fonts.pen-line>
                    @endif
                </div>
            @endif
        </x-slot>
        <!-- Dialog Content -->
        <x-slot name="content">
            <div>
                <x-input.group
                    class="border-0" for="current.caption" label="Bezeichnung" :error="$errors->first('current.caption')"
                    hoheLabel="h-6 sm:h-8 sm:pt-1" hohe="h-20 sm:h-10">
                    <x-input.text class="bg-sky-50 sm:h-8" wire:model.live="current.caption" id="current.caption" />
                </x-input.group>
               
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary wire:click="closeModal(false)">Abbrechen</x-button.secondary>
            <x-button.delete type="submit">Speichern</x-button.delete>
        </x-slot>
    </x-modal.dialog>
</form>



















