<?php

namespace App\Livewire\User\Occupant\CounterMeterReading;

use Livewire\Component;

class Header extends Component
{
    public $sorts = [];

    public function mount($sorts)
    {
        $this->sorts = $sorts;
    }

    public function sortByDatum()
    {
        $this->dispatch('SortByDatum');
    }

    public function render()
    {
        return view('livewire.user.occupant.counter-meter-reading.header');
    }
}
