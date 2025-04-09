<?php

namespace App\Livewire\User\Realestate;

use App\Models\Realestate;
use Livewire\Component;

class HeaderAddress extends Component
{
    public Realestate $realestate;

    public $editablePeriod = false;

    public function mount($baseobject)
    {
        $this->realestate = $baseobject;
    }

    public function rules()
    {
        return [
            'realestate.abrechnungssetting_id' => 'required',
        ];
    }

    public function updated($propertyName)
    {
        $this->realestate->save();

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.user.realestate.header-address');
    }
}
