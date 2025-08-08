<?php

namespace App\Livewire\User\Cost;

use App\Http\Traits\Helper\CostHelper;
use App\Http\Traits\Helpers;
use App\Livewire\DataTable\WithSorting;
use App\Models\Cost;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Betriebskostenliste extends Component
{
    use Helpers, CostHelper;
    use WireToast, WithSorting;
    public $showEditModal = false;
    public Realestate $realestate;

    /* initialization */
    public function mount($realestate)
    {
        $this->realestate = $realestate;
        $this->sorts = ['caption' => 'asc']; 
    }

    protected $listeners = [
        'refreshComponents' => '$refresh',
        'confirmNekoMessage' => 'confirmNekoMessage',      
    ];

    public function rules()
    {
        return [
            'current.nazwa' => 'required|min:2',
            'current' => 'sometimes',
            'current.dateCostAmount' => 'date|sometimes',
        ];
    }
 
    public function addCostModal()
    {
        $this->dispatch('addBetriebskostenCostDetailModal', $this->realestate);
    }

    #region übergabe an Eneko

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
    #endregion

    #region Dataselection
    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function getRowsQueryProperty()
    {
        $result = Cost::where('realestate_id', '=', $this->realestate->id)
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
            $query->IsBetriebskosten()
            ->with('costAmounts');
        });
        $this->applySorting($result);
        return $result;
    }
    #endregion

    public function render()
    {
        return view('livewire.user.cost.betriebskostenliste', [
            'filtered' => $this->rows,
        ]);
    }
}
