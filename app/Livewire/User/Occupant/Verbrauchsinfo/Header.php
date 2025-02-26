<?php

namespace App\Livewire\User\Occupant\Verbrauchsinfo;
use App\Models\Verbrauchsinfo;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Livewire\DataTable\WithSorting;


class Header extends Component
{

    public $verbrauchsinfo;
    public $sorts = [];


    public function mount(Verbrauchsinfo $verbrauchsinfo, $sorts)
    {
        $this->verbrauchsinfo = $verbrauchsinfo;
        $this->sorts  = $sorts;
    }

    public function sortByDatum()
    {
        $this->dispatch('SortByDatum');
    }

    public function render()
    {
        return view('livewire.user.occupant.verbrauchsinfo.header');
    }
}