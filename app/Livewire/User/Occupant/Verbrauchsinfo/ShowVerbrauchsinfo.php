<?php

namespace App\Livewire\User\Occupant\Verbrauchsinfo;

use App\Livewire\DataTable\WithCachedRows;
use App\Models\User;
use App\Models\UserVerbrauchsinfoAccessControl;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ShowVerbrauchsinfo extends Component
{
    use WithCachedRows;

    public User $user;

    public $occupants;

    public $filter;

    /* initialization */
    public function mount()
    {
        $this->user = User::query()->where('email', '=', Auth()->User()->email)->get()->first();
    }

    public function resetFilters()
    {
        $this->reset('filter');
    }

    public function getRowsQueryProperty()
    {
        $result = $this->user->userVerbrauchsinfoAccessControls->map(function (UserVerbrauchsinfoAccessControl $userControl) {
            return $userControl->occupant;
        })->unique()->toquery();

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
