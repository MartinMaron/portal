<?php

namespace App\Http\Livewire\User\Occupant\Verbrauchsinfo;

use Livewire\Component;
use App\Models\Occupant;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\UserVerbrauchsinfoAccessControl;

class ShowVerbrauchsinfos extends Component
{
    use WithCachedRows, WithSorting;
    protected $listeners = ['SortByDatum' => 'sortByDatum'];
    public Occupant $occupant;

    /* initialization */
    public function mount(Occupant $occupant)
    {
        $this->occupant = $occupant;
        $this->sorts = [
            'hk' => 'desc',
            'datum' => 'desc'
            ];
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
            })
            ;

        $result = $this->occupant->verbrauchsinfos
            ->whereIn('jahr_monat', $q)->toquery();

        $this->applySorting($result);
        return $result;
    }

    public function getVerbrauchsinfosByNutzergrupe($nutzergrupe_id){
        return $this->rows->where('nutzergrup_id','=',$nutzergrupe_id)
        ;
    }


    public function render()
    {
        $nutzergruppen = $this->rowsQuery
        ->orderBy('ww')
        ->get()->unique('nutzergrup_id');

        return view('livewire.user.occupant.verbrauchsinfo.search-list', [
            'rows' => $this->rows,
            'nutzergruppen' => $nutzergruppen,
        ]);
    }
}
