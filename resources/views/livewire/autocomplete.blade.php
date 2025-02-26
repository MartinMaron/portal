<div >
    <div
      x-data="{
        open: @entangle('showDropdown'),
        search: @entangle('search'),
        selected: @entangle('selected'),
        highlightedIndex: 0,
        highlightPrevious() {
          if (this.highlightedIndex > 0) {
            this.highlightedIndex = this.highlightedIndex - 1;
            this.scrollIntoView();
          }
        },
        highlightNext() {
          if (this.highlightedIndex < this.$refs.results.children.length - 1) {
            this.highlightedIndex = this.highlightedIndex + 1;
            this.scrollIntoView();
          }
        },
        scrollIntoView() {
          this.$refs.results.children[this.highlightedIndex].scrollIntoView({
            block: 'nearest',
            behavior: 'smooth'
          });
        },
        updateSelected(id, name) {
          this.selected = id;
          this.search = name;
          this.open = false;
          this.highlightedIndex = 0;
        },
      }">
    <div
      x-on:value-selected="updateSelected($event.detail.id, $event.detail.name)"
      class="relative">
      <span>
        <div >
          <x-input.text
            class="py-1"
            wire:model.debounce.300ms="search"
            x-on:keydown.arrow-down.stop.prevent="highlightNext()"
            x-on:keydown.arrow-up.stop.prevent="highlightPrevious()"
            x-on:keydown.enter.stop.prevent="$dispatch('value-selected', {
              id: $refs.results.children[highlightedIndex].getAttribute('data-result-id'),
              name: $refs.results.children[highlightedIndex].getAttribute('data-result-name')
            })">
          </x-input.text>
        </div>
      </span>
  
      <div
        x-show="open"
        x-on:click.away="open = false"
        class="absolute w-full">
          <ul x-ref="results" class="bg-sky-50">
            @forelse($results as $index => $result)
              <li
                wire:key="autocomplete-{{ $index }}"
                x-on:click.stop="$dispatch('value-selected', {
                  id: {{ $result->id }},
                  name: '{{ $result[$displaycolumn] }}'
                })"
                :class=" {
                  'bg-sky-400': {{ $index }} === highlightedIndex,
                  'text-white': {{ $index }} === highlightedIndex,
                }"
                class=""
                data-result-id="{{ $result->id }}"
                data-result-name="{{ $result[$displaycolumn] }}">
                  <span>
                    {{ $result[$displaycolumn] }}
                  </span>
              </li>
            @empty
              <li>No results found</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
