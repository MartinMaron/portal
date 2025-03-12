<?php

namespace App\Livewire\User\Occupant;

use App\Models\Occupant;
use Livewire\Component;

class PersonencountEdit extends Component
{
    public Occupant $occupant;

    public $countvalue;

    public function mount(Occupant $occupant)
    {
        $this->occupant = $occupant;
        $this->countvalue = $occupant->personen_zahl;
    }

    public function confirm()
    {
        $this->occupant->personen_zahl = floatval($this->countvalue);
        $this->occupant->save();
    }

    public function rules()
    {
        return [
            'occupant.personen_zahl' => 'nullable',
            'countvalue' => 'nullable',
        ];
    }

    public function render()
    {
        return view('livewire.user.occupant.countvalue-edit');
    }

    // public function render()
    // {
    //     return view('livewire.user.occupant.personencount-edit');
    // }
}
