<?php

namespace App\Livewire;

use Livewire\Component;

class ToggleButton extends Component
{
    public bool $hasStock;

    public function mount()
    {
        $this->hasStock = false;
    }

    public function render()
    {
        return view('livewire.toggle-button');
    }
}
