<?php

namespace App\Livewire\User\Occupant\Verbrauchsinfo;

use App\Models\Verbrauchsinfo;
use Livewire\Component;

class ListItem extends Component
{
    public $singleVerbrauchsinfo;

    public function mount(Verbrauchsinfo $singleVerbrauchsinfo)
    {
        $this->singleVerbrauchsinfo = $singleVerbrauchsinfo;
    }

    public function render()
    {
        return view('livewire.user.occupant.verbrauchsinfo.listitem');
    }
}
