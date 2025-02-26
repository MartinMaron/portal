<?php

namespace App\Http\Livewire\User\Occupant\CounterMeterReading;

use Livewire\Component;
use App\Models\Occupant;
use Illuminate\Support\Facades\App;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\UserVerbrauchsinfoAccessControl;
use Carbon\Carbon;

class ShowVerbrauchsinfoCounterMeterReading extends Component
{

    use WithSorting;

    protected $listeners = ['SortByDatum' => 'sortByDatum'];
    public $neko_id;
    public Occupant $occupant;

    /* initialization */

    public function mount(Occupant $occupant, $neko_id)
    {
        $this->neko_id = $neko_id;
        $this->occupant = $occupant;
        $this->sorts = ['datum' => 'asc'];
    }

    public function sortByDatum()
    {
        $this->sortBy('datum');
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function getRowsQueryProperty()
    {
        $q = $this->occupant->userVerbrauchsinfoAccessControls
        ->where('user_id', '=', auth()->user()->id)
        ->map(function (UserVerbrauchsinfoAccessControl $userControl) {
            return $userControl->jahr_monat ;
        });

        $result = $this->occupant->counterMeters
        ->where('nekoId', '=', $this->neko_id)
        ->whereIn('jahr_monat', $q)->toquery();

        return $this->applySorting($result);
    }

    public function render()
    {
        return view('livewire.user.occupant.counter-meter-reading.search-list', [
            'rows' => $this->rows,
            'sorts' => $this->sorts,
        ]);
    }
}
