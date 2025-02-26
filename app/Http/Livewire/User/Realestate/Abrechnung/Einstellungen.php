<?php

namespace App\Http\Livewire\User\Realestate\Abrechnung;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\Realestate;
use App\Models\Abrechnungssetting;
use Helpers;

class Einstellungen extends Component
{
    public Realestate $realestate;
    public Abrechnungssetting $einstellungen;

    public function mount($baseobject)
    {
        $this->realestate = $baseobject;
        $this->einstellungen = $this->realestate->abrechnungssetting;
     }
    
     public function commit(){
        $this->realestate->save();
        $this->einstellungen->save();
        toast()->success('Die Einstellungen wurden geändert.','Achtung')->push();
        return redirect(request()->header('Referer'));
     }


     public function rules()
     {
         return [
             'realestate.eingabeCostNetto' => 'nullable',      
             'realestate.eingabeCostDatum' => 'nullable',      
             'einstellungen.stromkosten' => 'numeric',      
             'einstellungen.nabi_inhaber' => 'nullable',
             'einstellungen.nabi_nr' => 'nullable',
             'einstellungen.co2_kennzeichen_WEG' => 'nullable',
             'einstellungen.co2_wohngeb' => 'nullable',
             'einstellungen.co2_kennzeichen_1_9' => 'nullable',
             'einstellungen.co2_kennzeichen_2_9' => 'nullable',
             'einstellungen.co2_anschluss_nach_2022' => 'nullable',
         ];
    }

    

    public function render()
    {
        return view('livewire.user.realestate.abrechnung.einstellungen');
    }
}
