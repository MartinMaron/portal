



<div class="max-w-xs">
<div
    x-data="{ open: false }"
    class="relative"
>
    <input id="combobox"
        wire:model.debounce.600ms="filters.search"
        x-on:click="open = ! open"
        x-on:focusIn="open = true"
        x-on:focusOut="open = false"
        type="text"
        class="w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-12 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" role="combobox" aria-controls="options" aria-expanded="false">
    <button type="button" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
        <!-- Heroicon name: solid/selector -->
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>



    <div x-show="open">
    <select
    class="relative cursor-default select-none py-2 pl-8 pr-4 text-gray-900" id="option-0" role="option" tabindex="-1">
        @foreach ($rows as $label)

                <!-- Selected: "font-semibold" -->
                <option value="{{ $label->id }}" class="block truncate">{{ $label->bezeichnung }}</option>

                @endforeach
            </select>

        </div>



</div>
</div>
