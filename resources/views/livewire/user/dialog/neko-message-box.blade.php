<div class="{{ $showNekoMessageMutex ? 'visible' : 'invisible' }}">
    <form wire:submit.prevent="confirm()">
        <x-modal.dialog class="bg-sky-50" minWidth="640px" maxWidth="800px" wire:model.defer="showNekoMessageMutex">
            <!-- Dialog Title -->
            <x-slot name="title">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    @if ($boxType === 'delete')
                        <i class="text-red-800 fa-solid fa-trash-can"></i>
                    @elseif ($boxType === 'warning')
                        <i class="text-orange-400 fa-solid fa-exclamation"></i>
                    @elseif ($boxType === 'info')
                        <i class="text-blue-800 fa-solid fa-info"></i>
                     @endif
                </div>
                <span class="mx-auto flex items-center justify-center text-center
                 {{ $boxType === 'delete' ? 'text-red-800 dark:text-red-500' :''}}
                 {{ $boxType === 'warning' ? 'text-orange-700 dark:text-yellow-100' :''}}
                 {{ $boxType === 'info' ? 'text-sky-700 dark:text-slate-200' :''}}"
                 >{{$title }}</span>
            </x-slot>   
            <!-- Dialog Content -->
            <x-slot name="content">
                <div class="mt-3 text-center sm:mt-5">
                    <div class="text-lg leading-6 font-medium 
                    {{ $boxType === 'delete' ?  'text-red-800 dark:text-red-500' :''}}
                    {{ $boxType === 'info' ? 'text-sky-700 dark:text-slate-200' :''}}"
                    id="modal-title">{{ $message}}</div>
                </div>
            </x-slot>
            <x-slot name="footer">
                @if ($boxType === 'delete')
                    <x-button.secondary wire:click="$set('showNekoMessageMutex', false)">{{ $cancelText }}</x-button.secondary>
                    <x-button.delete type="submit">{{ $submitText }}</x-button.delete>
                @elseif ($boxType === 'warning')
                    <x-button.secondary wire:click="$set('showNekoMessageMutex', false)">{{ $cancelText }}</x-button.secondary>
                    <x-button.secondary type="submit">{{ $submitText }}</x-button.secondary>
                @elseif ($boxType === 'info')
                    <x-button.secondary wire:click="$set('showNekoMessageMutex', false)">{{ $cancelText }}</x-button.secondary>
                    <x-button.secondary type="submit">{{ $submitText }}</x-button.secondary>
                @endif
            </x-slot>
        </x-modal.dialog>
    </form>
</div>
