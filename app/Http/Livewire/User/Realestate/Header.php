<?php

namespace App\Http\Livewire\User\Realestate;

use Livewire\Component;
use App\Models\Realestate;

class Header extends Component
{

    public Realestate $realestate;

    public function mount($baseobject)
    {
        $this->realestate = $baseobject;
    }

    public function render()
    {
         return view('livewire.user.realestate.header');
    }
}
