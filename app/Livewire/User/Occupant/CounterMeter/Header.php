<?php

namespace app\Http\Livewire\User\Occupant\CounterMeter;
use App\Models\VerbrauchsinfoCounterMeter;
use Livewire\Component;

namespace App\Livewire\User\Occupant\CounterMeter extends Component
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
        $this->dispatch('SortByNr');
    }

    public function render()
    {
        return view('class Header');
    }
}
