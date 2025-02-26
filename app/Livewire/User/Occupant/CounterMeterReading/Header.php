<?php

namespace App\Livewire\User\Occupant\CounterMeterReading;
use Carbon\Carbon;
use Livewire\Component;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Livewire\DataTable\WithSorting;

class Header extends Component
{

    public $sorts = [];

    public function mount($sorts)
    {
        $this->sorts  = $sorts;
      }

    public function sortByDatum()
    {
        $this->dispatch('SortByDatum');
    }


    public function render()
    {
        return view('class Header');
    }
}
