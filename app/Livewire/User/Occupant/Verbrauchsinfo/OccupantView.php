<?php

namespace App\Livewire\User\Occupant\Verbrauchsinfo;

use Livewire\Component;
use App\Models\Occupant;
use Illuminate\Support\Facades\Auth;
use App\Livewire\DataTable\WithCachedRows;

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
            ->where('user_id', '=', Auth::user()->id)
            ->sortBy('datum')->last();

        $result = $this->occupant->verbrauchsinfos->where('jahr_monat', '=', $res['jahr_monat']);

        return view('livewire.user.occupant.verbrauchsinfo.occupant-view', [
            'rows' => $result,
        ]);
    }
}
