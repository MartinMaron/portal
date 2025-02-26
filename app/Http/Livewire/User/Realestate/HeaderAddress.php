<?php

namespace App\Http\Livewire\User\Realestate;

use Livewire\Component;
use App\Models\Realestate;

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

        // $calcRules = null;
        // if ($this->dialogMode == 'change'){
        //     $calcRules = $this->validationRulesChange;
        // }else
        // {
        //     $calcRules = $this->validationRulesEdit;
        // }
        
        // $myRules = $calcRules[$this->currentPage];
        // $myRules['current.date_from_editing']=['required', 'date', new OccupantDateFromLessDateToRule];
        // $myRules['dateFromNewOccupant']=['required', 'date', new OcccupantDateFromGreaterPreviousRule];

        // $this->validateOnly($propertyName, $myRules, $this->messages);
    }



    public function render()
    {
        return view('livewire.user.realestate.header-address');
    }
}
