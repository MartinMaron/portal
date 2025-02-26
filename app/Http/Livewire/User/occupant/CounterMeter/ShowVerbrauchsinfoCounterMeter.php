<?php

namespace App\Http\Livewire\User\Occupant\CounterMeter;

use Livewire\Component;
use App\Models\Occupant;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Builder;
use app\Models\VerbrauchsinfoCounterMeter;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Models\UserVerbrauchsinfoAccessControl;


class ShowVerbrauchsinfoCounterMeter extends Component
{

    use WithCachedRows, WithSorting;

    protected $listeners = ['SortByNr' => 'sortByNr'];
    public Occupant $occupant;
    public VerbrauchsinfoCounterMeter $counterMeters;
    public String $jahr_monat;
    public $filter = [
        'search' => null,
    ];



    /* initialization */
    public function mount(Occupant $occupant, String $jahr_monat)
    {
         $this->occupant = $occupant;
         $this->jahr_monat = $jahr_monat;
         $this->sorts = [
            'hk' => 'desc',
            'nr' => 'asc'
            ];
        }

    public function sortByNr()
    {
        $this->sortBy('nr');
    }


    public function checkIfShowFunknr($nutzergrupe_id)
    {
        $query = $this->getCounterMetersByNutzergrupe($nutzergrupe_id)
        ->where(function (Builder $query) {$query->scopeNrFunknrEquals();});
    }


    public function getRowsQueryProperty()
    {

        $q = $this->occupant->userVerbrauchsinfoAccessControls
        ->where('user_id', '=', auth()->user()->id)
        ->sortByDesc('datum')
        ->map(function (UserVerbrauchsinfoAccessControl $userControl) {
            return $userControl->jahr_monat ;
        })->first();
        
        $result = $this->occupant->counterMeters
        ->where('jahr_monat', $q)->toquery();

        if ($this->filter['search']) {
            $result = $result
                ->where(function (Builder $query) {
                    $query->where('nr', 'LIKE', '%'. $this->filter['search'].'%')
                        ->orWhere('funkNr', 'LIKE', '%'. $this->filter['search'].'%');
                });
        };

        $this->applySorting($result);
        return $result;
    }

    public function getRowsProperty()
    {
         // return $this->cache(function () {
        return $this->rowsQuery->get();
        // });
    }


    public function getCounterMetersByNutzergrupe($nutzergrupe_id){
        return $this->rows->where('nutzergrup_id','=',$nutzergrupe_id)
                ->sortBy('hk')
        ;
    }


    public function render()
    {
        $nutzergruppen = $this->rowsQuery
        ->get()->unique('nutzergrup_id');
        ;

        return view('livewire.user.occupant.counter-meter.search-list', [
            'rows' => $this->rows,
            'nutzergruppen' => $nutzergruppen,
        ]);
    }
}
