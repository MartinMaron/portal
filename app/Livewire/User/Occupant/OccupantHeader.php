<?php

namespace App\Livewire\User\Occupant;

use App\Models\Occupant;
use Livewire\Component;

class OccupantHeader extends Component
{
    public $occupant;

    public $showStandardIcon = true;

    public $addAction = null;

    public $hasRealestateOccupantsDifferentAdresses = false;

    public function mount(Occupant $occupant)
    {
        $this->occupant = $occupant;
        $this->hasRealestateOccupantsDifferentAdresses = $this->occupant->realestate->has_occupants_different_adresses;
        if ($this->addAction != null) {
            /* $this->addAction = $addAction; */
            $this->showStandardIcon = false;
        }
    }

    public function raise_CreateVerbrauchsinfoUserEmailModal()
    {
        $this->dispatch($this->addAction, $this->occupant->nutzeinheitNo);
    }

    public function render()
    {
        return view('class OccupantHeader');
    }
}
