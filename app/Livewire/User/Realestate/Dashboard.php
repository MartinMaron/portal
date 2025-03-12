<?php

namespace App\Livewire\User\Realestate;

use App\Models\Realestate;
use Livewire\Component;

class Dashboard extends Component
{
    public Realestate $realestate;

    public function mount($baseobject)
    {
        $this->realestate = $baseobject;
    }

    public function render()
    {
        return view('livewire.user.realestate.dashboard');
    }
}
