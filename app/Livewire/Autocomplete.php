<?php

namespace App\Livewire;

use Livewire\Component;

abstract class Autocomplete extends Component
{
    public $results;

    public $search;

    public $selected;

    public $showDropdown;

    public $displaycolumn;

    public int $characterCount = 3;

    abstract public function query();

    public function mount($search)
    {
        $this->search = $search;
        $this->showDropdown = false;
        $this->results = collect();
    }

    public function updatedSelected()
    {
        $this->dispatch('autocomplete_valueSelected', $this->selected)->self();
    }

    public function updated($propertyName) {}

    public function updatedSearch()
    {
        if (strlen($this->search) <= $this->characterCount) {
            $this->results = collect();
            $this->showDropdown = false;

            return;
        }

        if ($this->query()) {
            $this->results = $this->query()->get();
        } else {
            $this->results = collect();
        }

        $this->selected = '';
        $this->showDropdown = true;
    }

    public function render()
    {
        return view('livewire.autocomplete');
    }
}
