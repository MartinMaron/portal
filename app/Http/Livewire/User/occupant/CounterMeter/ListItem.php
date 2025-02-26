<?php

namespace app\Http\Livewire\User\Occupant\CounterMeter;
use App\Models\VerbrauchsinfoCounterMeter;
use App\Models\Occupant;
use Livewire\Component;

class Listitem extends Component
{

    public VerbrauchsinfoCounterMeter $singleCounterMeter;
    public Occupant $occupant;

    public function mount($singleCounterMeter)
    {
        $this->singleCounterMeter = $singleCounterMeter;
        $this->occupant = $singleCounterMeter->occupant;
    }
    
    public function render()
    {
        return view('livewire.user.occupant.counter-meter.listitem');
    }
}
