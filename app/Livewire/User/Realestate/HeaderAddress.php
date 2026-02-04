<?php

namespace App\Livewire\User\Realestate;

use App\Models\Realestate;
use Livewire\Component;

class HeaderAddress extends Component
{
    public Realestate $realestate;

    public $editablePeriod = false;

    public $abrechnungssettingId;

    public function mount($baseobject)
    {
        $this->realestate = $baseobject;
        $this->abrechnungssettingId = $this->realestate->abrechnungssetting->id ?? $this->realestate->abrechnungssetting_id;
    }

    public function rules()
    {
        return [
            'abrechnungssettingId' => 'required|exists:abrechnungssettings,id',
        ];
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'abrechnungssettingId') {
            $this->realestate->abrechnungssetting_id = $this->abrechnungssettingId;
        }

        $this->realestate->save();

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.user.realestate.header-address');
    }
}
