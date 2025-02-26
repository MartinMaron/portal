<?php

namespace App\Http\Livewire\User\Costamount;

use Livewire\Component;
use App\Models\CostAmount;
use Usernotnull\Toast\Concerns\WireToast;

class Detail extends Component
{
  
    public CostAmount $costAmount;
    public $showCostAmountEditModal;
    public bool $showDatumField = true;
    public bool $readonlyDatumField = false;
    public bool $showConsumptionField = true;
    public bool $readonlyConsumptionField = true;
    public bool $showNetto = true;
    public bool $readonlyBetragField = false;
    public bool $showHaushaltsnahField = true;
    public bool $readonlyHaushaltsnahField = true;
    public bool $co2Tax = false;

    public function makeBlankObject()
    {
        return CostAmount::make([
            'bemerkung' =>'', 
            'description' => '',
            'netAmount' => 0, 
            'grosAmount' => 0,
            'grosAmount_HH'=> 0,  
        ]);
    }     
  
    protected $listeners = [
        'saveCostAmountDetail' => 'save',
        'showCostAmountDetailModal' => 'showCostAmountDetailModal',
        'closeCostAmountDetailModal' => 'closeCostAmountDetailModal',
    ];

  
    public function rules()
    {
        return [
            'costAmount.bemerkung' => 'nullable',      
            'costAmount.description' => 'nullable',
            'costAmount.consumption_editing' => 'required_if:costAmount.cost.consumption,==,1|nullable',
            'costAmount.netto' => 'nullable', 
            'costAmount.haushaltsnah' => 'nullable', 
            'costAmount.brutto' => 'required', 
            'costAmount.grosAmount_HH' => 'nullable',
            'costAmount.cobrutto' => 'nullable',
            'costAmount.conetto' => 'nullable',
            'costAmount.coconsupmtion' => 'nullable',
            'costAmount.datum' => 'required_if:costAmount.cost.fueltype.hasTank,==,1|date|nullable',
        ];
    }

    public function messages()
    {
        return [
            'costAmount.datum' => ':attribute muss angegeben werden',
            'costAmount.consumption_editing' => ':attribute muss angegeben werden' ,
        ];
    }

    public function attributes()
    {
        return [
            'costAmount.datum' => 'Datum',
            'costAmount.consumption_editing' => 'Verbrauch',
        ];
    }
   
   
    public function showCostAmountDetailModal (CostAmount $costAmount){
        $this->costAmount = $costAmount;
        $this->showCostAmountEditModal = true;
        $this->showConsumptionField = $costAmount->cost->consumption;
        $this->showNetto = $costAmount->cost->realestate->eingabeCostNetto;
        $this->showHaushaltsnahField = $costAmount->cost->haushaltsnah;
        $this->co2Tax = $costAmount->cost->co2Tax;
    }

    public function closeCostAmountDetailModal($save){
        if ($save && $this->costAmount){  
            if ($this->validate($this->rules(),$this->messages(),$this->attributes()))
            {
                $this->costAmount->save();
                $this->showCostAmountEditModal = false ;
                $this->emit('refreshComponents');    
            }else{
                $this->showCostAmountEditModal = false;              
            };
        }else{
            $this->showCostAmountEditModal = false;
        }             
   }
   

    
    public function render()
    {
        return view('livewire.user.costamount.detail');
    }
}
