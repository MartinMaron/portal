<?php

namespace App\Livewire\User\Cost;

use App\Http\Traits\Helper\CostHelper;
use App\Http\Traits\Helpers;
use App\Livewire\DataTable\WithSorting;
use App\Models\Cost;
use App\Models\CostType;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Heizkostenliste extends Component
{
    use Helpers, CostHelper;
    use WireToast;
    public $showEditModal = false;
    public Cost $current;
    public Realestate $realestate;

    /* initialization */
    public function mount($realestate)
    {
        $this->realestate = $realestate;
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
            $this->realestate->abrechnungssetting->heizkostenlisteDone = 1;
            $this->realestate->abrechnungssetting->save();
            return redirect(request()->header('Referer'));
        }
    }
    #endregion

    protected $listeners = [
        'refreshComponents' => '$refresh',
        'confirmNekoMessage' => 'confirmNekoMessage',
    ];

    public function addCostModal(Cost $costTemplate)
    {
        
        $this->dispatch('addHeizkostenCostDetailModal', $costTemplate);
    }
    
    #region Dataselection
    public function getRowsProperty()
    {
        return $this->rowsQuery->get()->unique('costtype_id')->sortBy('CostTypeSort');
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
            $query->IsHeizkosten()
            ->with('costAmounts');
        });
        return $result;
    }
    #endregion

    public function render()
    {
        return view('livewire.user.cost.heizkostenliste', [
            'costtypes' => $this->rows,
        ]);
    }
}
