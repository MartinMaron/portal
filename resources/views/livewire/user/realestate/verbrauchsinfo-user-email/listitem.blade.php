<div class="">
    {{-- big screen --}}
    <div class="hidden py-1 mx-1 border-t dark:border-slate-700  dark:text-slate-300 sm:block sm:max-w-7xl">
        <div class="flex items-center justify-between">
            <div class="basis-1/3 px-2 text-lg text-left dark:text-slate-300">
                {{ $userEmail->email }}
            </div>
            <div class="basis-1/3 flex justify-between">

                <div class="my-0.5 text-left dark:text-slate-800 {{ $userEmail->infoPerPortal ? 'bg-green-200 rounded-md': 'bg-red-200 rounded-md'}}">
                    <span class="px-2">Portal</span>
                    <span class="pr-1"><i class="{{ $userEmail->infoPerPortal ? 'fa-solid fa-check text-green-700 font-bold': 'fa-sharp fa-solid fa-ban text-red-700 font-bold'}} "></i></span>
                </div>
                <div class="my-0.5 text-left dark:text-slate-800 {{ $userEmail->infoPerEmail ? 'bg-green-200 rounded-md': 'bg-red-200 rounded-md'}}">
                    <span class="px-2">Email</span>
                    <span class="pr-1"><i class="{{ $userEmail->infoPerEmail ? 'fa-solid fa-check text-green-700 font-bold': 'fa-sharp fa-solid fa-ban text-red-700 font-bold'}} "></i></span>
                </div>
                <div class="my-0.5 text-left dark:text-slate-800  {{ $userEmail->infoPerPost ? 'bg-green-200 rounded-md': 'bg-red-200 rounded-md'}}">
                    <span class="px-2">Postbrief</span>
                    <span class="pr-1"><i class="{{ $userEmail->infoPerPost ? 'fa-solid fa-check text-green-700 font-bold': 'fa-sharp fa-solid fa-ban text-red-700 font-bold'}} "></i></span>
                </div>
            </div>
            <div class="basis-1/3 flex justify-end gap-5 py-1 text-center mx-1">
                <x-icon.fonts.pencil
                    class="px-4 py-1 text-sm border-2 rounded-lg cursor-pointer text-sky-700 border-sky-200 hover:text-sky-300"
                    wire:click="emit_EditModal()"
                    >
                </x-icon.fonts.pencil>
                <x-icon.fonts.trash
                    class="px-4 py-1 text-sm text-red-800 border-2 rounded-lg cursor-pointer border-sky-200 hover:text-red-600"
                    wire:click="emit_QuestionDeleteModal()"
                    >
                </x-icon.fonts.trash>
            </div>
        </div>
    </div>
    {{-- small screen --}}
    <div class="block p-1 sm:py-2 shadow-sm sm:hidden">
        <div class="flex justify-between items-center gap-3 w-full border-t dark:border-slate-700 ">
            <div class="pb-2 pl-1 text-lg sm:text-lg text-left dark:text-slate-300">
                {{ $userEmail->email }}
            </div>
            <div class="my-1">
                <x-jet-dropdown align="right" class="align-middle">
                    <x-slot name="trigger">
                        <button class="py-1 px-2 rounded-lg bg-sky-100 dark:bg-slate-800 border-sky-100 dark:border-slate-950 duration-150 text-xl text-sky-700 dark:text-slate-300 opacity-90 group-hover:opacity-100 ease">&ctdot;</button>
                    </x-slot>
                    <x-slot name="content">
                        <x-jet-dropdown-link class="cursor-pointer"
                        wire:click="emit_EditModal()"
                        >
                        <x-icon.fonts.pencil></x-icon.fonts.pencil>{{ __('Bearbeiten') }}
                        </x-jet-dropdown-link>
                        <x-jet-dropdown-link class="cursor-pointer"
                        wire:click="emit_QuestionDeleteModal()"
                        >
                        <x-icon.fonts.trash></x-icon.fonts.trash>{{ __('Löschen') }}
                        </x-jet-dropdown-link>
                    </x-slot>
                </x-jet-dropdown>
            </div>
        </div>
        
        <div class="flex justify-start items-center gap-3 ">
            <div class="{{ $userEmail->infoPerPortal ? 'bg-green-200 rounded-md': 'bg-red-200 rounded-md'}} text-xs py-0.5 px-2">Portal</div>
            <div class="{{ $userEmail->infoPerEmail ? 'bg-green-200 rounded-md': 'bg-red-200 rounded-md'}} text-xs py-0.5 px-2">Email</div>
            <div class="{{ $userEmail->infoPerPost ? 'bg-green-200 rounded-md': 'bg-red-200 rounded-md'}} text-xs py-0.5 px-2">Brief</div>
           
        </div>
    </div>
</div>
