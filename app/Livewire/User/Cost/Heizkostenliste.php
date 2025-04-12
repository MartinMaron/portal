<?php

namespace App\Livewire\User\Cost;

use App\Http\Traits\Helpers;
use App\Models\Cost;
use App\Models\CostType;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Heizkostenliste extends Component
{
    use Helpers;
    use WireToast;

    public $showEditModal = false;

    public $showEditFields = true;

    public $showFilters = false;

    public $nettoInputMode = false;

    public $dateInputMode = true;

    public $dateFrom = null;

    public Cost $current;

    public Realestate $realestate;

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
        $this->showEditFields = ! $realestate->heizkostenlisteDone;
    }

    public function setDone()
    {
        $this->dispatch('showNekoMessageModal', ['title' => 'Kostenliste absenden?', 'message' => 'Dannach können keine Änderungen mehr vorgenommen werden.', 'type' => 'warning', 'action' => 'confirmEditDone']);
    }

    public function confirmNekoMessage($params)
    {
        $this->params = $params;
        if ($this->params['action'] == 'confirmEditDone') {
            $this->realestate->abrechnungssetting->heizkostenlisteDone = 1;
            $this->realestate->abrechnungssetting->save();
            $this->showEditFields = ! $this->realestate->abrechnungssetting->heizkostenlisteDone;

            return redirect(request()->header('Referer'));
        }
    }

    public function makeBlankObject()
    {
        return Cost::make([
            'nekoId' => $this->realestate->nekoId,
            'realestate_id' => $this->realestate->id,
            'unvid' => $this->realestate->unvid,
            'budguid' => $this->realestate->nekoId,
            'costtype' => CostType::find('HNK'),
            'caption' => 'Neue Kostenposition',
        ]);
    }

    protected $listeners = [
        'changeProperty' => 'changeValue',
        'refreshComponents' => '$refresh',
        'confirmNekoMessage' => 'confirmNekoMessage',
    ];

    public function setCurrent(Cost $cost)
    {
        if ($this->current->isNot($cost)) {
            $this->current = $cost;
        }
    }

    public function raise_EditCostModal(Cost $cost)
    {
        $this->setCurrent($cost);
        $this->dispatch('showCostDetailModal', $this->current, false, false);
    }

    public function raise_AddCostModal(Cost $costTemplate)
    {
        $this->setCurrent($costTemplate);
        $this->dispatch('showCostDetailModal', $this->current, true, false);
    }

    public function hasConsumptionByType($costtypeId)
    {
        $ret = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                $query->IsHeizkosten();
            })
            ->where('costtype_id', '=', $costtypeId)
            ->where('consumption', '=', 1)
            ->count();

        return (bool) ($ret > 0);
    }

    public function hasHaushaltsnahByType($costtypeId)
    {
        $ret = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                $query->IsHeizkosten();
            })
            ->where('costtype_id', '=', $costtypeId)
            ->where('haushaltsnah', '=', 1)
            ->count();

        return (bool) ($ret > 0);
    }

    public function getCostByType($costtypeId){
        return Cost::where('realestate_id','=',$this->realestate->id)
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $this->realestate->abrechnungssetting->periodTo);
                }
            })
            ->where(function (Builder $query) {$query->IsHeizkosten();})
            ->where('costtype_id','=',$costtypeId)
            ->get();
    }

    public function render()
    {
        $costtypes = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $this->realestate->abrechnungssetting->periodTo);
                }
            })
            ->where(function (Builder $query) {
                $query->IsHeizkosten();
            })
            ->get()->unique('costtype_id')
            ->sortBy('CostTypeSort');

        return view('livewire.user.cost.heizkostenliste', [
            'costtypes' => $costtypes,
        ]);
    }
}
