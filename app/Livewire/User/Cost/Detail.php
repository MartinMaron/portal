<?php

namespace App\Livewire\User\Cost;

use App\Models\Cost;
use Livewire\Component;
use App\Models\CostType;
use App\Models\FuelType;
use App\Models\CostAmount;
use App\Models\Realestate;
use App\Http\Traits\Helper\CostHelper;
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

    /* initialization */
    public function mount()
    {
        $this->fueltypes = FuelType::all();
        $this->costtypes = CostType::all();
    }

    public function setCurrent($cost){
        $this->cost = $cost;
        $this->current = $this->cost->toArray();
        $this->costkeys = $cost->realestate->costsKeys;
    }

    protected $listeners = [
        'closeCostDetailModal' => 'closeModal',
        'showBetriebskostenCostDetailModal' => 'showModalBetriebskosten',
        'addBetriebskostenCostDetailModal' => 'createModalBetriebskosten',
        'showHeizkostenCostDetailModal' => 'showModalHeizkosten',
        'addHeizkostenCostDetailModal' => 'createModalHeizkosten',
        'showBrennstoffkostenCostDetailModal' => 'showModalBrennstoffkosten',
        'addBrennstoffkostenCostDetailModal' => 'createModalBrennstoffkosten',
        'editEndstandCostDetailModal' => 'editEndstand'
    ];

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'current.')) {
            $key = str_replace('current.', '', $propertyName);
            if ($key === 'fueltype_id') {
                $this->current['caption'] = $this->fueltypes->find($this->current['fueltype_id'])->caption ?? '';
                $this->cost->fueltype_id = $this->current['fueltype_id'];
                $this->current['fueltype'] = $this->fueltypes->find($this->current['fueltype_id']);
                $this->current['hasTank'] = $this->current['fueltype']->hasTank ?? false;
            }
        }
    }




    #region validation

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

    #endregion

    #region Brennstoffkosten
    public function createModalBrennstoffkosten(Cost $cost)
    {
        $this->cost = $this->makeBlankObjectBrennstoffkosten($cost);
        $this->setCurrent($this->cost);
        $this->dialogMode = 'create';
        $this->showEditModal = true;
    }

    public function showModalBrennstoffkosten(Cost $cost)
    {
        $this->cost = $cost;
        $this->setCurrent($this->cost);
        $this->current['fueltype'] = $this->cost->fueltype;
        $this->current['hasTank'] = $this->cost->fueltype->hasTank ?? false;
        $this->dialogMode = 'edit';
        $this->showEditModal = true;
    }
    #endregion

    #region Heizkosten-Modal
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

#endregion

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

    #region endstand
    function editEndstand(Cost $cost)
    {
        $this->setCurrent($cost);
        $this->current['fueltype'] = $this->cost->fueltype;
        $this->current['hasTank'] = $this->cost->fueltype->hasTank ?? false;
        $this->dialogMode = 'stand';
        $this->showEditModal = true;
    }
        

    #endregion

    public function closeModal($save)
    {
        if ($save) {
            $this->cost->co2Tax = $this->hasCo2Tax($this->cost);
            if ($this->validate($this->rules(), $this->messages(), $this->attributes())) {
                if ($this->cost->costtype != null && $this->cost->costtype_id == 'BRK') {
                    $this->cost->consumption = true;
                }
                $this->cost->OptimisticLockField = $this->cost->OptimisticLockField + 1;
                $this->cost = $this->fill_changed_data_from($this->current, $this->cost);
                $this->cost->save();
                $this->cost->refresh();

                //Falls es Brennstoffkosten mit Tank gibt, dann die Tankdaten speichern
                if ($this->cost->costtype_id == 'BRK' && $this->cost->fueltype && $this->cost->fueltype->hasTank) {
                    if ($this->dialogMode == 'create') {
                        
                        $costAmount = CostAmount::firstOrNew([
                            'cost_id' => $this->cost->id,
                            'abrechnungssetting_id' => $this->cost->realestate->abrechnungssetting_id,
                            'startvalue' => true,
                        ]);
                        $costAmount->startvalue = true;
                        $costAmount->endvalue = false;
                        $costAmount->abrechnungssetting_id = $this->cost->realestate->abrechnungssetting_id;
                        $costAmount->consumption = floatval(str_replace(',', '.', str_replace('.', '', $this->current['start_value_editing'])));
                        $costAmount->netAmount = floatval(str_replace(',', '.', str_replace('.', '', $this->current['start_value_amount_net_editing'])));
                        $costAmount->grosAmount = floatval(str_replace(',', '.', str_replace('.', '', $this->current['start_value_amount_gros_editing'])));
                        $costAmount->save();

                        $costAmount = CostAmount::firstOrNew([
                            'cost_id' => $this->cost->id,
                            'abrechnungssetting_id' => $this->cost->realestate->abrechnungssetting_id,
                            'endvalue' => true,
                        ]);
                        $costAmount->startvalue = false;
                        $costAmount->endvalue = true;
                        $costAmount->abrechnungssetting_id = $this->cost->realestate->abrechnungssetting_id;
                        $costAmount->consumption = floatval(str_replace(',', '.', str_replace('.', '', $this->current['end_value_editing'])));
                        $costAmount->save();

                    }elseif ($this->dialogMode == 'edit') {
                            $this->cost->end_value_editing = $this->current['end_value_editing'];
                            $this->cost->start_value_editing = $this->current['start_value_editing'];
                            $this->cost->start_value_amount_net_editing = $this->current['start_value_amount_net_editing'];
                            $this->cost->start_value_amount_gros_editing = $this->current['start_value_amount_gros_editing'];
                        }
                    elseif ($this->dialogMode == 'stand') {
                        $this->cost->end_value_editing = $this->current['end_value_editing'];
                    }
                }

                $this->showEditModal = false;
                toast()->success('Speichervorgang erfolgreich', 'Achtung')->push();
                return redirect(request()->header('Referer'));
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
