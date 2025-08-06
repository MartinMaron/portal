<?php

namespace App\Livewire\User\Cost;

use Livewire\Component;
use App\Models\Cost;
use App\Models\CostType;
use App\Models\CostAmount;
use Illuminate\Database\Eloquent\Builder;

class Betriebskosteneingabe extends Component
{
    public $realestate;
    public $costs;
    public $current;
    public $nettoInputMode;
    public $dateInputMode;
    public $showEditFields;
    public $nettobetraege = [];
    public $bruttobetraege = [];
    public $haushaltsnahBetraege = [];

    public $eingabeModus = 'netto'; // 'netto' or 'brutto'
    public $showHaushaltsnah = false;
    public $sortColumn = 'none';
    public $sortDirection = 'none';
    
    public function mount($realestate)
    {
        $this->realestate = $realestate;
        $this->costs = $realestate->costs()
                                ->isBetriebskosten()
                                ->with('costAmounts') // Eager load to prevent N+1 queries
                                ->get();
        
        foreach ($this->costs as $cost) {
            if ($cost->costAmounts->isNotEmpty()) {
                $costAmount = $cost->costAmounts->first();
                $this->nettobetraege[$cost->id] = number_format($costAmount->netAmount, 2, ',', '.');
                $this->bruttobetraege[$cost->id] = number_format($costAmount->grosAmount, 2, ',', '.');
                $this->haushaltsnahBetraege[$cost->id] = number_format($costAmount->grosAmount_HH, 2, ',', '.');
            }else{
                $this->nettobetraege[$cost->id] = '0,00';
                $this->bruttobetraege[$cost->id] = '0,00';
                $this->haushaltsnahBetraege[$cost->id] = '0,00';
            } 
        }

        $this->current = $this->makeBlankObject();
        $this->nettoInputMode = $realestate->eingabeCostNetto;
        $this->dateInputMode = $realestate->eingabeCostDatum;
        $this->showEditFields = $realestate->kosteneingabe;
    }
    
    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            if ($this->sortDirection === 'asc') {
                $this->sortDirection = 'desc';
            } elseif ($this->sortDirection === 'desc') {
                $this->sortDirection = 'none';
            } else {
                $this->sortDirection = 'asc';
            }
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }

        if ($this->sortDirection === 'none') {
            $this->mount($this->realestate); // Reset to original order
            return;
        }

        $descending = $this->sortDirection === 'desc';

        switch ($this->sortColumn) {
            case 'caption':
                $this->costs = $this->costs->sortBy('caption', SORT_REGULAR, $descending);
                break;
            case 'haushaltsnah':
                $this->costs = $this->costs->sortBy(function ($cost) {
                    return floatval(str_replace(',', '.', str_replace('.', '', $this->haushaltsnahBetraege[$cost->id] ?? '0,00')));
                }, SORT_REGULAR, $descending);
                break;
        }
    }

    public function makeBlankObject()
        {
            return Cost::make([
                'nekoId' => $this->realestate->nekoId,
                'realestate_id' => $this->realestate->id,
                'unvid' => $this->realestate->unvid,
                'budguid' => $this->realestate->nekoId,
                'costtype' => CostType::find('BEK'),
                'caption' => 'Neue Kostenposition',
            ]);
        }

    public function render()
    {
        return view('livewire.user.cost.betriebskosteneingabe');
    }

    public function updatedNettobetraege($value, $key)
    {
        $this->saveAmount($key, 'netAmount', $value);
        $this->nettobetraege[$key] = number_format(floatval(str_replace(',', '.', str_replace('.', '', $value))), 2, ',', '.');
    }

    public function updatedBruttobetraege($value, $key)
    {
        $this->saveAmount($key, 'grosAmount', $value);
        $this->bruttobetraege[$key] = number_format(floatval(str_replace(',', '.', str_replace('.', '', $value))), 2, ',', '.');
    }

    public function updatedHaushaltsnahBetraege($value, $key)
    {
        $this->saveAmount($key, 'grosAmount_HH', $value);
        $this->haushaltsnahBetraege[$key] = number_format(floatval(str_replace(',', '.', str_replace('.', '', $value))), 2, ',', '.');
    }

    private function saveAmount($costId, $field, $value)
    {
        $costAmount = CostAmount::firstOrNew([
            'cost_id' => $costId,
            'abrechnungssetting_id' => $this->realestate->abrechnungssetting_id,
        ]);

        $costAmount->{$field} = floatval(str_replace(',', '.', str_replace('.', '', $value)));
        
        if (!$costAmount->exists) {
            $costAmount->startvalue = 0;
            $costAmount->endvalue = 0;
        }

        $costAmount->save();
      
        // Dispatching to our custom toast component.
        $this->dispatch('show-toast-notification', message: 'Gespeichert', type: 'success');
    }
}
