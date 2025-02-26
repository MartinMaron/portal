<?php

namespace app\Http\Livewire\User\Occupant;

use Livewire\Component;
use App\Models\Occupant;
use Barryvdh\Debugbar\Facades\Debugbar;

class VorauszahlungEdit extends Component
{

    public Occupant $occupant;
    public $countvalue;


    public function mount(Occupant $occupant){
        $this->occupant = $occupant;
        $this->countvalue = $occupant->vorauszahlung_editing;
      }

    public function confirm()
    {
        $this->occupant->vorauszahlung_editing = floatval($this->countvalue);
        $this->occupant->save();
    }

    public function rules() { return [
         'occupant.vorauszahlung_editing' => 'nullable',
         'countvalue' => 'nullable',
    ]; }
    public function render()
    {
        return view('livewire.user.occupant.countvalue-edit');
    }
}
