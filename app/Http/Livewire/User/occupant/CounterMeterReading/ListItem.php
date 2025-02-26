<?php

namespace App\Http\Livewire\User\Occupant\CounterMeterReading;
use App\Models\VerbrauchsinfoCounterMeter;
use Livewire\Component;

class Listitem extends Component
{

    public $counterMeter;

    public function mount(VerbrauchsinfoCounterMeter $counterMeter)
    {
        $this->counterMeter = $counterMeter;
    }

    public function render()
    {
        return view('livewire.user.occupant.counter-meter-reading.listitem');
    }
}
