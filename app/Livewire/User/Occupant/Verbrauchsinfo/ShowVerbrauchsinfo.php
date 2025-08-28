<?php

namespace App\Livewire\User\Occupant\Verbrauchsinfo;

use App\Models\User;
use Livewire\Component;
use App\Models\Occupant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Livewire\DataTable\WithCachedRows;
use App\Models\UserVerbrauchsinfoAccessControl;


class ShowVerbrauchsinfo extends Component
{
    use WithCachedRows;

    public User $user;

    public $occupants;

    public $filter;

    /* initialization */
    public function mount()
    {
        $this->user = User::query()->where('email', '=', Auth::user()->email)->get()->first();
    }

    public function resetFilters()
    {
        $this->reset('filter');
    }

    public function getRowsQueryProperty()
    {
        $collection = $this->user->userVerbrauchsinfoAccessControls->map(function (UserVerbrauchsinfoAccessControl $userControl) {
            return $userControl->occupant;
        })->unique();

        if ($collection->isEmpty()) {
            return Occupant::query()->whereRaw('1 = 0');
        }

        $result = $collection->toQuery();

        if ($this->filter) {
            $result = $result
                ->where(function (Builder $query) {
                    $query->where('address', 'LIKE', '%'.$this->filter.'%')
                        ->orWhere('lage', 'LIKE', '%'.$this->filter.'%')
                        ->orWhere('unvid', 'LIKE', '%'.$this->filter.'%');
                });
        }

        return $result;
    }


    public function getRowsProperty()
    {
        // return $this->cache(function () {
        return $this->rowsQuery->get();
        // });
    }

    public function render()
    {
        return view('livewire.user.occupant.verbrauchsinfo.show-verbrauchsinfo', [
            'rows' => $this->Rows,
        ]);
    }
}
