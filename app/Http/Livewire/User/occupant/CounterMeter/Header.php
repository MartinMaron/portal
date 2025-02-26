<?php

namespace app\Http\Livewire\User\Occupant\CounterMeter;
use App\Models\VerbrauchsinfoCounterMeter;
use Livewire\Component;

class Header extends Component
{


    public $counterMeter;
    public $sorts = [];


    public function mount(VerbrauchsinfoCounterMeter $counterMeter, $sorts)
    {
        $this->counterMeter = $counterMeter;
        $this->sorts  = $sorts;

    }

    public function sortByNr()
    {
        $this->emit('SortByNr');
    }

    public function render()
    {
        return view('livewire.user.occupant.counter-meter.header');
    }
}
