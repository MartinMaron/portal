<?php

namespace App\Http\Livewire\User\Cost;
use App\Models\Cost;
use Livewire\Component;
use App\Models\Costtype;
use App\Models\Fueltype;
use App\Models\Realestate;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Database\Eloquent\Builder;



class Detail extends Component
{
    use WireToast; 
    public $cost = null;
    public $showEditModal = false;
    public $costtypes = null;
    public $fueltypes = null;
    public $costkeys = null;
    public bool $netAmountInput = false;
    public bool $onlyConsumptionEdit = false;

    /* initialization */
    public function mount(Cost $cost, bool $netAmountInput, string $costinvoicingtype)
    {
        $this->cost = $cost;
        $this->fueltypes = Fueltype::all();
        $this->costkeys = $cost->realestate->costsKeys;
        $this->costtypes = Costtype::all();
        $this->netAmountInput = $netAmountInput;
    }

    protected $listeners = [
        'showCostDetailModal' => 'showModal',
        'closeCostDetailModal' => 'closeModal',
        'showBetriebskostenCostDetailModal'=> 'showModalBetriebskosten',
        'addBetriebskostenCostDetailModal'=> 'addModalBetriebskosten',
    ];
 
    public function rules()
    {
        return [
            'cost.caption' => 'required|min:2',      
            'cost.costtype_id' => 'required',
            'cost.fueltype_id' => 'nullable', 
            'cost.start_value_editing' => 'nullable', 
            'cost.start_value_amount_gros_editing'=> 'nullable',
            'cost.start_value_amount_net_editing'=> 'nullable',
            'cost.end_value_editing' => 'nullable', 
            'cost.haushaltsnah' => 'nullable', 
            'cost.co2Tax'=> 'required',
            'cost.costkey_id' => 'nullable', 
            'cost.noticeForUser' => 'nullable', 
            'cost.noticeForNeko' => 'nullable', 
            'cost.consumption' => 'nullable', 
            'cost.prevyearPeriod' => 'nullable',
            'cost.prevyearAmountnet' => 'nullable',
            'cost.prevyearAmountgros' => 'nullable', 
            'cost.nekoId' => 'required', 
            'cost.realestate_id' => 'required', 
        ];
    }

    public function makeBlankObject(Cost $cost)
    {
        return Cost::make([
            'nekoId' => 0,
            'realestate_id' => $cost->realestate->id,
            'costtype_id' => $cost->costtype_id,
            'consumption' => false
        ]);
    }

    public function makeBlankObjectBetriebskosten(Realestate $realestate)
    {
        return Cost::make([
            'nekoId' => 0,
            'realestate_id' => $realestate->id,
            'costtype_id' => 'BEK',
            'consumption' => false,
            'caption' => 'neue Kostenposition'
        ]);
    }

    public function showModal (Cost $cost, $add, $onlyConsumptionEdit){
        if ($add) {
            $this->cost = $this->makeBlankObject($cost);
        } else {
            $this->cost = $cost;
        }
        $this->costtypes = Costtype::where('costinvoicingtype_id','=', 'HZ')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = $onlyConsumptionEdit;
        $this->showEditModal = true;
    }

    public function showModalBetriebskosten (Cost $cost){
        $this->cost = $cost;
        $this->costtypes = Costtype::where('costinvoicingtype_id','=', 'BE')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = false;
        $this->showEditModal = true;
    }

    public function addModalBetriebskosten (Realestate $realestate){
        $this->cost = $this->makeBlankObjectBetriebskosten($realestate);
        $this->costtypes = Costtype::where('Costinvoicingtype_id','=', 'BE')->get()->sortBy('sort');
        $this->onlyConsumptionEdit = false;
        $this->showEditModal = true;
    }

    public function closeModal($save){
        if ($save){
            $this->cost->co2Tax = $this->cost->can_co2;
            if ($this->cost->costtype != null && $this->cost->costtype_id == 'BRK') {
                $this->cost->consumption = true;
            }
            $this->cost->OptimisticLockField = $this->cost->OptimisticLockField + 1;            
            $this->validate();
            $this->cost->save();
            $this->showEditModal = false;
            $this->emit('refreshComponents');         
        }else{
            $this->showEditModal = false;
        }       
   }

   

    public function render()
    {
       return view('livewire.user.cost.detail');
    }
}
