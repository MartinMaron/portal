<?php

namespace App\Livewire\User\Cost;

use App\Http\Traits\Helper\CostHelper;
use App\Models\Cost;
use App\Models\CostType;
use App\Models\FuelType;
use App\Models\Realestate;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Detail extends Component
{
    use WireToast;
    use CostHelper;

    public $current = null;
    public Cost $cost;
    public $showEditModal = false;
    public $dialogMode = 'init'; // Modal Dialog Mode: init, edit, create
    public $costtypes = null;
    public $fueltypes = null;
    public $costkeys = null;
    public bool $netAmountInput = false;
    public bool $onlyConsumptionEdit = false;
    public $haushaltsnah;

    /* initialization */
    public function mount()
    {
        $this->fueltypes = FuelType::all();
        $this->costtypes = CostType::all();
    }

    public function setCurrent($cost){
        $this->current = $this->cost->toArray();
        $this->cost = $cost;
        $this->costkeys = $cost->realestate->costsKeys;
        $this->haushaltsnah = $cost->haushaltsnah;
    }

    protected $listeners = [
        'closeCostDetailModal' => 'closeModal',
        'showBetriebskostenCostDetailModal' => 'showModalBetriebskosten',
        'addBetriebskostenCostDetailModal' => 'createModalBetriebskosten',
        'showHeizkostenCostDetailModal' => 'showModalHeizkosten',
        'addHeizkostenCostDetailModal' => 'createModalHeizkosten',
    ];

// #region validation

    public function rules()
    {
        return [
            'current.caption' => 'required|min:2',
            'current.costtype_id' => 'required',
            'current.fueltype_id' => 'nullable',
            'current.start_value_editing' => 'nullable',
            'current.start_value_amount_gros_editing' => 'nullable',
            'current.start_value_amount_net_editing' => 'nullable',
            'current.end_value_editing' => 'nullable',
            'current.haushaltsnah' => 'nullable',
            'current.co2Tax' => 'required',
            'current.costkey_id' => 'nullable',
            'current.noticeForUser' => 'nullable',
            'current.noticeForNeko' => 'nullable',
            'current.periodFrom' => 'nullable',
            'current.periodTo' => 'nullable',
            'current.consumption' => 'nullable',
            'current.prevyearPeriod' => 'nullable',
            'current.prevyearAmountnet' => 'nullable',
            'current.prevyearAmountgros' => 'nullable',
            'current.nekoId' => 'required',
            'current.realestate_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'current.caption' => ':attribute muss angegeben werden',
        ];
    }

    public function attributes()
    {
        return [
            'current.caption' => 'Bezeichnung',
        ];
    }

// #endregion
    
    /* public function showModal(Cost $cost, $add, $onlyConsumptionEdit)
    {
        if ($add) {
            $this->cost = $this->makeBlankObject($cost);
        } else {
            $this->cost = $cost;
        }
 
        $this->costtypes = CostType::where('costinvoicingtype_id', '=', 'HZ')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = $onlyConsumptionEdit;
        $this->showEditModal = true;
    } */

    public function showModalHeizkosten(Cost $cost)
    {
        $this->cost = $cost;
        $this->setCurrent($this->cost);
        $this->costtypes = CostType::where('costinvoicingtype_id', '=', 'HZ')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = false;
        $this->dialogMode = 'edit';
        $this->showEditModal = true;
    }

    public function createModalHeizkosten(Cost $cost)
    {
        $this->cost = $this->makeBlankObjectHeizkosten($cost);
        $this->setCurrent($this->cost);
        $this->costtypes = CostType::where('costinvoicingtype_id', '=', 'HZ')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = false;
        $this->showEditModal = true;
        $this->dialogMode = 'create';
    }



    #region Betriebskosten-Modal
    public function showModalBetriebskosten(Cost $cost)
    {
        $this->cost = $cost;
        $this->setCurrent($this->cost);
        $this->costtypes = CostType::where('costinvoicingtype_id', '=', 'BE')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = false;
        $this->dialogMode = 'edit';
        $this->showEditModal = true;
    }

    public function createModalBetriebskosten(Realestate $realestate)
    {
        $this->cost = $this->makeBlankObjectBetriebskosten($realestate);
        $this->setCurrent($this->cost);
        $this->costtypes = CostType::where('Costinvoicingtype_id', '=', 'BE')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = false;
        $this->showEditModal = true;
        $this->dialogMode = 'create';
    }
    #endregion

    public function closeModal($save)
    {
        if ($save) {
            $this->cost->co2Tax = $this->hasCo2Tax($this->cost);
            if ($this->validate($this->rules(), $this->messages(), $this->attributes())) {
                /* if ($this->cost->costtype != null && $this->cost->costtype_id == 'BRK') {
                    $this->cost->consumption = true;
                }
                $this->cost->OptimisticLockField = $this->cost->OptimisticLockField + 1; */
                $this->cost = $this->fill_changed_data_from($this->current, $this->cost);
                $this->cost->save();
                $this->showEditModal = false;
                toast()->success('Speichervorgang erfolgreich', 'Achtung')->push();
                $this->dispatch('refreshComponents');
            }
        } else {
            $this->showEditModal = false;
        }
    }

    public function render()
    {
        return view('livewire.user.cost.detail');
    }
}
