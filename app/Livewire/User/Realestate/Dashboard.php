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

    public Function getLastDoneAbrechnung(){
        $abrechnung = $this->realestate->abrechnungssettings
            ->whereNotNull('hk_id')
            ->where('hk_id', '!=', '00000000-0000-0000-0000-000000000000')
            ->sortByDesc('periodTo')->first();
        return $abrechnung;
    }

    public function getAbrechnungForDownload(){
        if ($this->realestate->abrechnungssetting->hk_id !=null && $this->realestate->abrechnungssetting->hk_id != '00000000-0000-0000-0000-000000000000' ){
            return $this->realestate->abrechnungssetting;
        }else{
            return $this->getLastDoneAbrechnung();
        }
    }

    public function render()
    {
        return view('livewire.user.realestate.dashboard');
    }
}
