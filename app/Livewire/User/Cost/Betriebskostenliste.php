<?php

namespace App\Livewire\User\Cost;

use App\Http\Traits\Helpers;
use App\Livewire\DataTable\WithSorting;
use App\Models\Cost;
use App\Models\CostType;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Betriebskostenliste extends Component
{
    use Helpers;
    use WireToast, WithSorting;
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
        $this->showEditFields = $realestate->kosteneingabe;
        $this->sorts = ['caption' => 'asc']; 
    }

    public function makeBlankObject()
    {
        return Cost::make([
            'nekoId' => $this->realestate->nekoId,
            'realestate_id' => $this->realestate->id,
            'unvid' => $this->realestate->unvid,
            'budguid' => $this->realestate->nekoId,
            'costtype' => CostType::find('BEK'),
            'caption' => 'Neue Kostenposition',
        ]);
    }

    protected $listeners = [
        'changeProperty' => 'changeValue',
        'refreshComponents' => '$refresh',
        'confirmNekoMessage' => 'confirmNekoMessage',      
    ];
   

    public function create()
    {
        if ($this->current->getKey()) {
            $this->current = $this->makeBlankTransaction();
        }
        $this->showEditModal = true;
    }

    public function setDone()
    {
        $this->dispatch('showNekoMessageModal', ['title' => 'Kostenliste absenden?', 'message' => 'Dannach können keine Änderungen mehr vorgenommen werden.', 'type' => 'warning', 'action' => 'confirmEditDone']);
    }

    public function confirmNekoMessage($params)
    {
        $this->params = $params;
        if ($this->params['action'] == 'confirmEditDone') {
            $this->realestate->abrechnungssetting->betreibskostenDone = 1;
            $this->realestate->abrechnungssetting->save();
            $this->showEditFields = ! $this->realestate->abrechnungssetting->betreibskostenDone;

            return redirect(request()->header('Referer'));
        }
    }

    public function raise_EditCostModal(Cost $cost)
    {
        $this->setCurrent($cost);
        $this->dispatch('showBetriebskostenCostDetailModal', $this->current);
    }

    public function raise_AddCostModal()
    {
        $this->dispatch('addBetriebskostenCostDetailModal', $this->realestate);
    }

    public function hasConsumptionByType($costtypeId)
    {
        $ret = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                $query->IsBetriebskosten();
            })
            ->where('costtype_id', '=', $costtypeId)
            ->where('consumption', '=', 1)
            ->count();

        return (bool) ($ret > 0);
        // return $ret;
    }

    public function hasHaushaltsnahByType($costtypeId)
    {
        $ret = Cost::where('realestate_id', '=', $this->realestate->id)
            ->where(function (Builder $query) {
                $query->IsBetriebskosten();
            })
            ->where('costtype_id', '=', $costtypeId)
            ->where('haushaltsnah', '=', 1)
            ->count();

        return (bool) ($ret > 0);
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function getRowsQueryProperty()
    {
        $result = Cost::where('realestate_id', '=', $this->realestate->id)
        ->where(function (Builder $query) {
            $query->IsBetriebskosten()
            ->with('costAmounts');
        });

        $this->applySorting($result);
        debuger
        return $result;
    }


    public function render()
    {
        return view('livewire.user.cost.betriebskostenliste', [
            'filtered' => $this->rows,
        ]);
    }
}
