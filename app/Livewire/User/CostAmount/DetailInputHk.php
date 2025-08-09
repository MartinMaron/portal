<?php

namespace App\Livewire\User\CostAmount;

use App\Models\Cost;
use App\Http\Traits\Helper\CostHelper;
use Livewire\Component;
use App\Models\CostAmount;
use App\Http\Traits\Helpers;
use Usernotnull\Toast\Concerns\WireToast;

class DetailInputHk extends Component
{
    use WireToast, Helpers, CostHelper;

    public Cost $cost;
    public $consumption;
    public $betrag;
    public $haushaltsnah;

    public function mount(Cost $cost)
    {
        $this->cost = $cost;
        $this->loadValues();
    }

    function loadValues()
    {
       $costAmount = $this->getDefaultCostAmount($this->cost);
       $this->haushaltsnah = $costAmount->haushaltsnah ?? '0,00';
       $this->consumption = $costAmount->consumption_editing ?? '0,0';
       if ($this->cost->realestate->eingabeCostNetto) {
           $this->betrag = $costAmount->netto ?? '0,00';
       } else {
           $this->betrag = $costAmount->brutto ?? '0,00';
       }       
    }


    protected $listeners = [
        'refreshDetailInput' => 'refreshByid',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'consumption'){
            $this->saveCostAmountField('consumption', $this->consumption);
        }
        if ($propertyName === 'betrag'){
            $this->saveCostAmountField($this->cost->realestate->eingabeCostNetto ? 'netAmount' : 'grosAmount', $this->betrag);
        }
        if ($propertyName === 'haushaltsnah'){
            $this->saveCostAmountField('grosAmount_HH', $this->haushaltsnah);
        }
    }

    public function editCostModal(Cost $cost)
    {
        $this->dispatch('showHeizkostenCostDetailModal', $cost);
    }

    public function rules()
    {
        return [
            'consumption' => 'required_if:cost.consumption,==,1|nullable|min:0|not_in:0',
            'betrag' => 'nullable',
            'haushaltsnah' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'current.datum' => ':attribute muss angegeben werden',
            'current.consumption_editing' => ':attribute muss angegeben werden',
        ];
    }

    public function attributes()
    {
        return [
            'current.datum' => 'Datum',
            'current.consumption_editing' => 'Verbrauch',
        ];
    }
   
    private function saveCostAmountField($field, $value)
    {
        $costAmount = $this->getDefaultCostAmount($this->cost);
        if (!$costAmount->exists) {
            $costAmount->startvalue = 0;
            $costAmount->endvalue = 0;
            $costAmount->consumption = 0;  
            $costAmount->grosAmount = 0;
            $costAmount->netAmount = 0;
            $costAmount->haushaltsnah = 0;
            $costAmount->co2TaxAmount_gros = 0;
            $costAmount->co2TaxAmount_net = 0;
            $costAmount->co2TaxValue = 0;
            $costAmount->abrechnungssetting_id = $this->cost->realestate->abrechnungssetting_id;
            $costAmount->cost_id = $this->cost->id; 

        }
        $costAmount->{$field} = floatval(str_replace(',', '.', str_replace('.', '', $value)));
        $costAmount->save();
        $this->loadValues();
  
    }

    public function render()
    {
       return view('livewire.user.costamount.detail-input-hk');
    }
}
