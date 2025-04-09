<?php

namespace App\Livewire\User\CostAmount;

use App\Models\Cost;
use App\Models\CostAmount;
use Livewire\Component;

class Listitem extends Component
{
    public CostAmount $current;

    public bool $netto;

    public Cost $cost;

    public bool $withoutDatum;

    protected $listeners = [
        // 'refreshCostAmountDetailInput' => 'refreshByid'
        // 'refreshComponents' => '$refresh',
    ];

    public function mount(CostAmount $costAmount, $netto, $withoutDatum)
    {
        $this->current = $costAmount;
        $this->netto = $netto;
        $this->cost = $costAmount->cost;
        $this->withoutDatum = $withoutDatum;
    }

    public function startFieldDefault()
    {
        if ($this->cost->consumption) {
            return 'consumption';
        }

        if ($this->cost->consumption) {
            return 'consumption';
        }
    }

    public function questionDeleteCostAmount()
    {
        $this->dispatch('deleteCostAmount', $this->current);
    }

    public function raise_EditCostAmountModal()
    {
        $this->dispatch('showCostAmountDetailModal', $this->current);
    }

    public function refreshByid($id)
    {
        $this->dispatch('refreshByid', $id);

        if ($id == $this->current->id) {
            // $this->dispatch('refreshByid', $this->current->id );

            // $this->dispatch('$refresh');

            // $this->render();
        }
    }

    public function render()
    {
        return view('livewire.user.costamount.listitem');
    }
}
