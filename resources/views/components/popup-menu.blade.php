<div
      class="align-middle rounded-lg bg-sky-100 border-sky-100"
      x-data="{ 'isHamburgerOpen': false }"
      @keydown.escape="isHamburgerOpen = false"
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
            class="absolute pl-2 text-left -ml-28">
            {{ $slot }}
        </ul>
    </div>
</div>
