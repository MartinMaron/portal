<?php

namespace App\Http\Livewire\User\Cost;

use App\Models\Cost;
use Livewire\Component;
use App\Models\CostAmount;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;
use Usernotnull\Toast\Concerns\WireToast;

class Brennstoffliste extends Component
{
    use WireToast; use \App\Http\Traits\Helpers;

    public $showEditModal = false;
    public $showEditFields = true;
    public $showFilters = false;
    public $nettoInputMode = false;
    public $dateInputMode = true;
    public $currentCostAmount = null;
    public $dateFrom = null;
    public Cost $current;
    public Realestate $realestate;
    public bool $hasManyBrennstoffkosten = false;
    public $nekoerrors = array();

    public function rules()
    {
        return [
            'current.nazwa' => 'required|min:2',
            'current' => 'sometimes',
            'current.dateCostAmount' => 'date|sometimes',
        ];
    }

    /* initialization */
    public function mount($realestate)
    {
        $this->realestate = $realestate;
        $this->current = $this->makeBlankObject();
        $this->nettoInputMode = $realestate->eingabeCostNetto;
        $this->dateInputMode = $realestate->eingabeCostDatum;
        $this->showEditFields = !$realestate->abrechnungssetting->brennstofflisteDone;
        $this->hasManyBrennstoffkosten = (bool)(Cost::where('realestate_id','=',$this->realestate->id)
                                        ->where(function (Builder $query) {$query->IsBrennstoffkosten();})
                                        ->count() > 1);
    }

    public function makeBlankObject()
    {
        return Cost::make([
            'nekoId' => $this->realestate->nekoId,
            'realestate_id' => $this->realestate->id,
            'unvid' => $this->realestate->unvid,
            'budguid' => $this->realestate->nekoId,
            'caption' => 'neu',
        ]);
    }

    protected $listeners = [
                            'changeProperty' => 'changeValue',
                            'refreshComponents' => '$refresh',
                            'showCostAmountDetailInListaModal' => 'raise_EditCostAmountModal',
                            'confirmNekoMessage' => 'confirmNekoMessage',
                        ];

    
    public function confirmNekoMessage($params)
    {
        $this->params = $params;
        if ($this->params['action'] == 'confirmEditDone') {
            $this->realestate->abrechnungssetting->brennstofflisteDone = 1;
            $this->realestate->abrechnungssetting->save();
            $this->showEditFields = !$this->realestate->abrechnungssetting->nutzerlisteDone;
            return redirect(request()->header('Referer'));
        }
        if ($this->params['action'] == 'deleteCostAmount') {
            $this->currentCostAmount->delete();
        }
    }


    public function setDone()
    {
        $this->nekoerrors = array();
        foreach($this->realestate->costs->where('costtype_id','=','BRK') as $item) {
            
            // für Kosten ohne Tank müssen irgendwelche Kosten eingetragen werden
            if ($item->fueltype_id !=null && !$item->fueltype->hasTank) {
                if ($item->netto == "0,00" && $item->brutto == "0,00" ) {
                    $this->nekoerrors[]= $item->caption. ': keine Kosten angegeben.';
                }
            }
            
            if ($item->fueltype_id !=null && $item->fueltype->hasTank){
                $q = $item->costAmounts()->where('abrechnungssetting_id','=', $item->realestate->abrechnungssetting_id)
                ->where('endvalue','=', true)->get();
                if ($q->count() > 0) {
                    if ($q->first()->consumption == 0)
                    {
                        $this->nekoerrors[]= $item->caption. ': kein Endstand angegeben.';
                    }
                } else {
                    $this->nekoerrors[]= $item->caption. ': kein Endstand angegeben.';
                }
            }
        }
        if (!$this->nekoerrors) {
            $this->emit('showNekoMessageModal',['title'=>'Brennstoffliste absenden?','message'=>'Dannach können keine Änderungen mehr vorgenommen werden.','type'=>'warning','action'=>'confirmEditDone']);
        }
    }

    public function create()
    {
        if ($this->current->getKey()) $this->current = $this->makeBlankTransaction();
        $this->showEditModal = true;
    }

    public function setCurrent(Cost $cost)
    {
        if ($this->current->isNot($cost)) {
            $this->current = $cost;
        }
    }

    public function raise_EditCostModal(Cost $cost)
    {
        $this->setCurrent($cost);
        $this->emit('showCostDetailModal', $this->current, false, false);
    }

    public function raise_AddCostModal(Cost $costTemplate)
    {
        $this->setCurrent($costTemplate);
        $this->emit('showCostDetailModal', $this->current, true, false);
    }

    public function raise_EditCostConsumptionModal(Cost $cost)
    {
        $this->setCurrent($cost);
        $this->emit('showCostDetailModal', $this->current, false, true);
    }

    public function editCostAmountModal(CostAmount $costAmount)
    {
        $this->emit('showCostAmountDetailModal', $costAmount);
    }

    public function questionDeleteCostAmount(CostAmount $costAmount)
    {
        $this->currentCostAmount = $costAmount;
        $this->emit('showNekoMessageModal',['title'=>'Löschen?','message'=>'Bitte das löschen bestätigen.','type'=>'delete','action'=>'deleteCostAmount']);
    }

    public function getCostByType($costtypeId){
        return Cost::where('realestate_id','=',$this->realestate->id)
        ->where(function (Builder $query) {$query->IsBrennstoffkosten();})
        ->where('costtype_id','=',$costtypeId)
        ->get();
    }

    public function hasConsumptionByType($costtypeId){
      
        $ret = Cost::where('realestate_id','=',$this->realestate->id)
        ->where(function (Builder $query) {$query->IsBrennstoffkosten();})
        ->where('costtype_id','=',$costtypeId)
        ->where('consumption','=', 1)
        ->count();
        return (bool)($ret > 0);
    }

    public function hasHaushaltsnahByType($costtypeId){
        $ret = Cost::where('realestate_id','=',$this->realestate->id)
        ->where(function (Builder $query) {$query->IsBrennstoffkosten();})
        ->where('costtype_id','=',$costtypeId)
        ->where('haushaltsnah','=', 1)
        ->count();
        return (bool)($ret > 0);
        // return $ret;
    }

    public function render()
    {
        $filtered = Cost::where('realestate_id','=',$this->realestate->id)
        ->where(function (Builder $query) {$query->IsBrennstoffkosten();})
        ->get()->unique('costtype_id')
        ->sortBy('CostTypeSort');

        $filtered->fresh('costAmounts');

        return view('livewire.user.cost.brennstoffliste', [
            'filtered' => $filtered
        ]);
    }
}
