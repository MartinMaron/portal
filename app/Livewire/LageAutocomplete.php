<?php

namespace App\Livewire;

use App\Models\Lage;

class LageAutocomplete extends Autocomplete
{
    protected $listeners = ['valueSelected'];

    public $displaycolumn = 'caption';

    public int $characterCount = 0;

    public function mount($search)
    {
        $this->search = $search;
        $this->showDropdown = false;
        $this->results = collect();
    }

    public function updated($propertyName)
    {
        if ($propertyName = 'search') {
            $this->dispatch('LageAutocompleteDisplaychanged', $this->search);
        }
    }

    public function valueSelected(Lage $lage)
    {
        $this->dispatch('lageautocomplete_selected', $lage);
    }

    public function query()
    {
        return Lage::where('caption', 'like', $this->search.'%')->orderBy('caption');
    }
}
