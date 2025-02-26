<?php

namespace App\Http\Livewire;

use App\Models\Lage;
use App\Models\User;
use Livewire\Component;
use Barryvdh\Debugbar\Facades\Debugbar;

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
        Debugbar::info('LageAutocomplete-updated:'. $propertyName);
        if ($propertyName = 'search') {
            $this->emitUp('LageAutocompleteDisplaychanged', $this->search);
        } 
    }


    public function valueSelected(Lage $lage)
    {
        $this->emitUp('lageautocomplete_selected', $lage);
    }

    public function query() {
        return Lage::where('caption', 'like', $this->search.'%')->orderBy('caption');
    }

}
