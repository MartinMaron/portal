<?php

namespace App\Livewire\User\Cost;

use App\Models\Cost;
use Livewire\Component;
use App\Models\CostAmount;
use App\Models\Realestate;
use App\Http\Traits\Helpers;
use App\Http\Traits\Helper\CostHelper;
use App\Mail\Abrversenden;
use Illuminate\Database\Eloquent\Builder;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


class Brennstoffliste extends Component
{
    use Helpers, CostHelper;
    use WireToast;

    public $editable = false;
    public Realestate $realestate;
    public $nekoerrors = [];

    /* initialization */
    public function mount($realestate)
    {
        $this->realestate = $realestate;
        $this->editable = ! $realestate->abrechnungssetting->brennstofflisteDone;
    }



    protected $listeners = [
        'refreshComponents' => '$refresh',
        'confirmNekoMessage' => 'confirmNekoMessage',
    ];

    public function confirmNekoMessage($params)
    {
        $this->params = $params;
        if ($this->params['action'] == 'confirmEditDone') {
            $this->realestate->abrechnungssetting->brennstofflisteDone = 1;
            $this->realestate->abrechnungssetting->save();
            $this->editable = ! $this->realestate->abrechnungssetting->nutzerlisteDone;
            if ( $this->realestate->inWorkAbrechnung()) {
                $this->sendEmail();
            } 
            return redirect(request()->header('Referer'));
        }
        if ($this->params['action'] == 'deleteCostAmount') {
            CostAmount::find($params['object']['id'])->delete();
        }
    }



    public function setDone()
    {
        $this->nekoerrors = [];
        foreach ($this->getCostByType('BRK', $this->realestate) as $item) {

            // für Kosten ohne Tank müssen irgendwelche Kosten eingetragen werden
            if (
                $item->fueltype_id != null
                && !$item->fueltype->hasTank
            ) {
                if ($item->netto == '0,00' && $item->brutto == '0,00') {
                    $this->nekoerrors[] = $item->caption . ': keine Kosten angegeben.';
                }
            }

            if ($item->fueltype_id != null && $item->fueltype->hasTank) {
                $q = $item->costAmounts()->where('abrechnungssetting_id', '=', $item->realestate->abrechnungssetting_id)
                    ->where('endvalue', '=', true)->get();
                if ($q->count() > 0) {
                    if ($q->first()->consumption == 0) {
                        $this->nekoerrors[] = $item->caption . ': kein Endstand angegeben.';
                    }
                } else {
                    $this->nekoerrors[] = $item->caption . ': kein Endstand angegeben.';
                }
            }

            if ($item->co2Tax) {
                $q = $item->costAmounts()->where('abrechnungssetting_id', '=', $item->realestate->abrechnungssetting_id)
                    ->where('endvalue', '=', 0)
                    ->where('startvalue', '=', 0)
                    ->get();

                if ($q->sum('co2TaxValue') == 0) {
                    $this->nekoerrors[] = $item->caption . ': keine CO2-Menge angegeben.';
                }
                if ($q->sum('co2TaxAmount_gros') == 0 && $q->sum('co2TaxAmount_net') == 0) {
                    $this->nekoerrors[] = $item->caption . ': keine CO2-Kosten angegeben.';
                }
            }
        }
        if (! $this->nekoerrors) {
            $this->dispatch('showNekoMessageModal', ['title' => 'Brennstoffliste absenden?', 'message' => 'Dannach können keine Änderungen mehr vorgenommen werden.', 'type' => 'warning', 'action' => 'confirmEditDone']);
        }
    }

    public function sendEmail()
    {
        try {
            toast()->success('Ihr Anliegen wurde gesendet', 'Achtung')->push();
            Mail::to('info@e-neko.de')
                ->cc(Auth::user()->send_info_email ? Auth::user()->send_info_email : '')
                ->send(new Abrversenden($this->realestate));
        } catch (\Exception $e) {
            toast()->danger('Fehler beim Senden der Email: ' . $e->getMessage())->push();
        }
    }


    public function editCostModal(Cost $cost)
    {
        $this->dispatch('showBrennstoffkostenCostDetailModal', $cost);
    }

    public function addCostModal(Cost $costTemplate)
    {
        $this->dispatch('addBrennstoffkostenCostDetailModal', $costTemplate);
    }

    public function editEndstand(Cost $cost)
    {
        $this->dispatch('editEndstandCostDetailModal', $cost);
    }

    public function editCostAmountModal(CostAmount $costAmount)
    {
        $this->dispatch('showCostAmountDetailModal', $costAmount);
    }

    public function questionDeleteCostAmount(CostAmount $costAmount)
    {
        $this->dispatch('showNekoMessageModal', ['title' => 'Löschen?', 'message' => 'Bitte das löschen bestätigen.', 'type' => 'delete', 'action' => 'deleteCostAmount', 'object' => $costAmount]);
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
                $query->IsBrennstoffkosten()
                    ->with('costAmounts');
            });
        return $result;
    }
    #endregion


    public function render()
    {
        return view('livewire.user.cost.brennstoffliste', [
            'rows' => $this->rows,
        ]);
    }
}
