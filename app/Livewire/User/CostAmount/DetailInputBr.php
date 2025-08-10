<?php

namespace App\Livewire\User\CostAmount;

use App\Http\Traits\Helper\CostHelper;
use App\Http\Traits\FormatsNumbers;
use App\Models\Cost;
use App\Models\CostAmount;
use Livewire\Component;
use PhpParser\Node\Expr\Cast\Double;
use Usernotnull\Toast\Concerns\WireToast;
use App\Http\Traits\Helpers;

class DetailInputBr extends Component
{
    use WireToast, CostHelper, Helpers, FormatsNumbers;
    public Cost $cost;
    public $current;
    /**
     * Mapping der numerischen Felder zu ihren Nachkommastellen für Formatierung.
     */
    protected array $numericFormatMap = [
        'current.netto' => 2,
        'current.brutto' => 2,
        'current.consumption_editing' => 1,
        'current.coconsupmtion' => 0,
        'current.cobrutto' => 2,
        'current.conetto' => 2,
        'current.haushaltsnah' => 2,
        'current.grosAmount_HH' => 2,
    ];
    
    public function mount(Cost $cost)
    {
        $this->cost = $cost;
        $costAmount= $this->makeBlankObject();
        $this->current = $costAmount->toArray();
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
            'bemerkung' => '',
            'co2TaxAmount_net' => 0,
            'co2TaxAmount_gros' => 0,
            'description' => '',
        ]);
    }

    public function refreshByid($id)
    {
        if ($id == $this->cost->id) {
            $this->dispatch('$refresh');
        }
    }

    public function updated($propertyName)
    {
        $this->handleNumericFormatting($propertyName);
        if (($this->cost->costtype_id ?? null) !== 'BRK') {
            $this->save();
        }
    }

    public function raise_EditCostModal(Cost $cost)
    {
        $this->dispatch('showBrennstoffkostenCostDetailModal');
    }

    public function rules()
    {
        return [
            'current.cost_id' => 'required',
            'current.consumption_editing' => 'required_if:cost.consumption,==,1|nullable|min:0|not_in:0',
            'current.brutto' => 'nullable',
            'current.netto' => 'nullable',
            'current.haushaltsnah' => 'nullable',
            'current.grosAmount_HH' => 'nullable',
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

    public function save()
    {
    debugbar()->info($this->current);
        if ($this->validate($this->rules(), $this->messages(), $this->attributes())) {
            $costAmount = $this->getNewCostAmount($this->cost);
            $costAmount->fill(collect($this->current)->toArray());
            $costAmount->endvalue = false;
            $costAmount->startvalue = false;
            $costAmount->abrechnungssetting_id = $this->cost->realestate->abrechnungssetting_id;
            $costAmount->cost_id = $this->cost->id;
            $costAmount->netto = $this->castStringToDouble($this->current['netto'] ?? null);
            $costAmount->brutto = $this->castStringToDouble($this->current['brutto'] ?? null);
            $costAmount->consumption = $this->castStringToDouble($this->current['consumption_editing'] ?? null);
            $costAmount->co2TaxValue = $this->castStringToDouble($this->current['coconsupmtion'] ?? null);
            $costAmount->co2TaxAmount_gros = $this->castStringToDouble($this->current['cobrutto'] ?? null);
            $costAmount->co2TaxAmount_net = $this->castStringToDouble($this->current['conetto'] ?? null);
            $costAmount->datum = $this->current['datum'];
            if ($costAmount->save()) {
                $costAmount = $this->makeBlankObject();
                $this->current = $costAmount->toArray();
                $this->dispatch('refreshComponents');
            }
        }
    }

    public function updatedNettobetraege($value, $key)
    {
        $this->saveAmount($key, 'netAmount', $value);
        $this->nettobetraege[$key] = number_format(floatval(str_replace(',', '.', str_replace('.', '', $value))), 2, ',', '.');
    }


    




    public function render()
    {
        return view('livewire.user.costamount.detail-input-br');
    }
}
