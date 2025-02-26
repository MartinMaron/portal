<?php

namespace app\Http\Livewire\User\Occupant\Verbrauchsinfo;

use Livewire\Component;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Models\Occupant;
use App\Models\Verbrauchsinfo;

class OccupantView extends Component
{
    use WithCachedRows;
    public $occupant;

    /* initialization */
    public function mount(Occupant $pOccupant)
    {
        $this->occupant = $pOccupant;
    }

    public function render()
    {
        $res = $this->occupant->userVerbrauchsinfoAccessControls
        ->where('user_id', '=', auth()->user()->id)
        ->sortBy('datum')->last();

        $result = $this->occupant->verbrauchsinfos->where('jahr_monat', '=', $res['jahr_monat']) ;

        return view('livewire.user.occupant.verbrauchsinfo.occupant-view', [
            'rows' => $result,
        ]);
    }
}
