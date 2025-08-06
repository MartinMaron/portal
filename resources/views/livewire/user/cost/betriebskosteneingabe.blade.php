<div x-data="gridNavigation()">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Betriebskosteneingabe</h1>
    </div>

    <div class="my-4">
        <fieldset>
            <legend class="text-base font-medium text-gray-900">Eingabeeinstellungen</legend>
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model.live="eingabeModus" value="netto" class="form-radio">
                    <span class="ml-2">Nettobeträge eingeben</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" wire:model.live="eingabeModus" value="brutto" class="form-radio">
                    <span class="ml-2">Bruttobeträge eingeben</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="checkbox" wire:model.live="showHaushaltsnah" class="form-checkbox">
                    <span class="ml-2">Haushaltsnahe Dienstleistungen anzeigen</span>
                </label>
            </div>
        </fieldset>
    </div>

    <div class="py-4">
        <div class="shadow overflow-hidden rounded border-b border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm cursor-pointer" wire:click="sortBy('caption')">
                            Bezeichnung
                            @if ($sortColumn === 'caption')
                                @if ($sortDirection === 'asc')
                                    <span>&#9650;</span>
                                @elseif ($sortDirection === 'desc')
                                    <span>&#9660;</span>
                                @endif
                            @endif
                        </th>
                        @if($showHaushaltsnah)
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm cursor-pointer" wire:click="sortBy('haushaltsnah')">
                            Haushaltsnah
                            @if ($sortColumn === 'haushaltsnah')
                                @if ($sortDirection === 'asc')
                                    <span>&#9650;</span>
                                @elseif ($sortDirection === 'desc')
                                    <span>&#9660;</span>
                                @endif
                            @endif
                        </th>
                        @endif
                        @if ($eingabeModus === 'netto')
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Betrag (Netto)</th>
                        @endif
                        @if ($eingabeModus === 'brutto')
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Betrag (Brutto)</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="text-gray-700" @keydown.arrow-down.prevent="focusNext($event.target, 1)" @keydown.arrow-up.prevent="focusNext($event.target, -1)" @keydown.arrow-right.prevent="focusNext($event.target, 0, 1)" @keydown.arrow-left.prevent="focusNext($event.target, 0, -1)">
                    @foreach ($costs as $index => $cost)
                         <tr data-row="{{ $index }}">
                            <td class="text-left py-3 px-4">{{ $cost->caption }}</td>
                            @if($showHaushaltsnah)
                            <td class="text-left py-3 px-4">
                                <input type="text" 
                                       wire:model.lazy="haushaltsnahBetraege.{{ $cost->id }}"
                                       data-col="0"
                                       class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-right">
                            </td>
                            @endif
                            @if ($eingabeModus === 'netto')
                                <td class="text-left py-3 px-4">
                                    <input type="text" 
                                           wire:model.lazy="nettobetraege.{{ $cost->id }}"
                                           data-col="{{ $showHaushaltsnah ? 1 : 0 }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-right">
                                </td>
                            @endif
                            @if ($eingabeModus === 'brutto')
                                <td class="text-left py-3 px-4">
                                    <input type="text" 
                                           wire:model.lazy="bruttobetraege.{{ $cost->id }}"
                                           data-col="{{ $showHaushaltsnah ? 1 : 0 }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm text-right">
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function gridNavigation() {
        return {
            focusNext(currentElement, rowOffset, colOffset = 0) {
                const currentTr = currentElement.closest('tr');
                const currentRow = parseInt(currentTr.dataset.row);
                const currentCol = parseInt(currentElement.dataset.col);

                let nextRow = currentRow + rowOffset;
                let nextCol = currentCol + colOffset;

                let nextTr = this.$el.querySelector(`tr[data-row="${nextRow}"]`);
                if (!nextTr) return; // No more rows in this direction

                let nextInput = nextTr.querySelector(`input[data-col="${nextCol}"]`);
                
                // If we are moving horizontally and there's no input in the next column, stay in the same column
                if (colOffset !== 0 && !nextInput) {
                    nextInput = nextTr.querySelector(`input[data-col="${currentCol}"]`);
                }

                if (nextInput) {
                    nextInput.focus();
                    nextInput.select();
                }
            }
        }
    }
</script>
