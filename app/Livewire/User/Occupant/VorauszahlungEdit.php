<?php

namespace App\Livewire\User\Occupant;

use App\Models\Occupant;
use Livewire\Component;

class VorauszahlungEdit extends Component
{
    public Occupant $occupant;

    public $countvalue;

    public function mount(Occupant $occupant)
    {
        $this->occupant = $occupant;
        $this->countvalue = $occupant->vorauszahlung_editing;
    }

    public function confirm()
    {
        $this->occupant->vorauszahlung_editing = $this->countvalue;
    }

    public function rules()
    {
        return [
            'occupant.vorauszahlung_editing' => 'nullable',
            'countvalue' => 'nullable',
        ];
    }

    public function render()
    {
        return view('livewire.user.occupant.countvalue-edit');
    }
}
