<main
      class="h-8 max-w-4xl mx-auto rounded-lg md:flex-1 bg-sky-100 border-sky-100"
      x-data="{ 'isDialogOpen': false }"
      @keydown.escape="isDialogOpen = false"
>

        <div class="text-right" x-data="{ 'isHamburgerOpen': false }">
            <button
              type="button"
              title="Open the actions menu"
              class="px-2 font-mono text-2xl"
              @click="isHamburgerOpen = true"
              :class="{ 'rounded-lg cursor-pointer border-sky-200': isHamburgerOpen }"
            >
              &ctdot;
            </button>

            <ul 
                x-show="isHamburgerOpen"
                x-cloak
                @click.away="isHamburgerOpen = false"
                class="absolute -mt-10 -ml-12 text-left bg-white border shadow-md ">
              <li>
                <x-icon.fonts.pencil 
                class="px-4 py-1 text-sm border-2 rounded-lg border-sky-200"
                wire:click="emit_EditModal()">
                </x-icon.fonts.pencil>
                <span>Redigieren</span>  
              </li>
              <li>
                <x-icon.fonts.trash 
                class="px-4 py-1 text-sm border-2 rounded-lg border-sky-200"
                wire:click="emit_QuestionDeleteModal()"> 
                </x-icon.fonts.trash>
                <span>Löschen</span>
              </li>
            </ul>
        </div>
</main>