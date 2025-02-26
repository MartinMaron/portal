<?php

namespace App\Http\Livewire\User\Costamount;

use App\Models\Cost;
use Livewire\Component;
use App\Models\CostAmount;
use PhpParser\Node\Expr\Cast\Double;
use Barryvdh\Debugbar\Facades\Debugbar;
use PhpParser\Node\NullableType;
use Usernotnull\Toast\Concerns\WireToast;

class DetailInput extends Component
{
    use WireToast;

    public Cost $cost;
    public $datum;
    public Double $comsumption;
    public Double $amount;
    public Double $amountHh;
    public $netto;
    public bool $inputWithDate;
    public bool $inputNet;
    public int $index;
    public int $editedindex = 1;
    public bool $hasChanges = false;
    public bool $saved = false;
    public bool $editable = true;

    public CostAmount $current;
    public string $inputStartField;

    public function mount(Cost $cost, $netto, $inputWithDatum) {
        $this->cost = $cost;
        $this->inputNet = $netto;
        $this->inputWithDate = $inputWithDatum;
        
        if ($this->inputWithDate || ($this->cost->fueltype != null && $this->cost->fueltype->hasTank)) {
            $this->inputStartField = 'datum';
        }else {
            if ($this->cost->consumption) {
                $this->inputStartField = 'consumption';
            }else{ 
                $this->inputStartField = 'betrag';
            }
        }
        // nur für Brennstoffkosten können mehrere Beträge eingegeben werden
        // für alle anderen existiert nuer ein CostAmount als Singelton für Abrechnungszeitraum
        if ($this->cost->costtype_id == 'BRK') {
            $this->current = $this->makeBlankObject();
        } else {
           $qAmounts = $this->cost->costAmounts->where('abrechnungssetting_id','=',$this->cost->realestate->abrechnungssetting_id);
           if($qAmounts->count()>0){
                $this->current = $qAmounts->first();
           }else{
                $this->current = $this->makeBlankObject();
           }
        }
        $this->editable = $this->cost->editable ;
    }

    protected $listeners = [
         'refreshDetailInput' => 'refreshByid',
    ];

    public function makeBlankObject()
    {
       return CostAmount::make([
            'nekoCostId' => $this->cost->nekoId,
            'cost_id' => $this->cost->id,
            'abrechnungssetting_id' => $this->cost->realestate->abrechnungssetting_id,
            'bemerkung' =>'',
            'co2TaxAmount_net' => 0,
            'co2TaxAmount_gros' => 0,
            'description' => '',
        ]);
    }

    public function refreshByid($id){
        if ($id == $this->cost->id){
            $this->emit('$refresh');
        }
    }

    public function updated($propertyName)
    {
        if (! $this->cost->costtype == 'BRK'){
            $this->save();
        }
    }

    public function raise_EditCostModal(Cost $cost)
    {
        $this->emit('showCostDetailModal', $cost, false, false);
    }

    public function rules()
    {
        return [
            'current.cost_id' => 'required',
            'current.consumption_editing' => 'required_if:cost.consumption,==,1|nullable|min:0|not_in:0',
            'current.brutto' => 'nullable',
            'current.netto' => 'nullable',
            'current.haushaltsnah' => 'nullable',
            'current.description' => 'nullable',
            'current.cobrutto' => 'nullable',
            'current.conetto' => 'nullable',
            'current.coconsupmtion' => 'nullable',
            'current.datum' => 'required_if:cost.fueltype.hasTank,==,1|date|nullable',
            'current.abrechnungssetting_id' => 'nullable',
       ];
    }
    public function messages()
    {
        return [
            'current.datum' => ':attribute muss angegeben werden',
            'current.consumption_editing' => ':attribute muss angegeben werden' ,
        ];
    }

    public function attributes()
    {
        return [
            'current.datum' => 'Datum',
            'current.consumption_editing' => 'Verbrauch',
        ];
    }

    public function save()
    {
        if ($this->validate($this->rules(),$this->messages(),$this->attributes())){
            if ($this->cost->costtype->id =='BRK') {
                if(CostAmount::create(collect($this->current)->toArray()))  {
                    $this->current = $this->makeBlankObject();
                    $this->emit('refreshComponents');
                }
            } else {
                CostAmount::updateOrcreate(
                    ['cost_id' => $this->cost->id, 
                    'abrechnungssetting_id' => $this->cost->realestate->abrechnungssetting_id,],
                    [
                        'brutto'=>$this->current->brutto,
                        'netto'=>$this->current->netto,
                        'datum'=>$this->current->datum,
                        'consumption_editing'=>$this->current->consumption_editing,
                        'cobrutto'=>$this->current->cobrutto,
                        'conetto'=>$this->current->conetto,
                        'coconsupmtion'=>$this->current->coconsupmtion,
                        'haushaltsnah'=>$this->current->haushaltsnah,
                    ]
                );
            }
        };
    }

    public function render()
    {
        if($this->cost->costtype->id=='BRK')
        {
             return view('livewire.user.costamount.detail-input-br');
        }else{
            if($this->cost->costtype->costinvoicingtype_id =='BE'){ 
                return view('livewire.user.costamount.detail-input-bk');
            } 
            if($this->cost->costtype->costinvoicingtype_id =='HZ'){ 
                return view('livewire.user.costamount.detail-input-hk');
            } 
        }

    }
}
