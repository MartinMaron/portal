<?php

namespace App\Livewire\User\Realestate;

use Livewire\Component;
use App\Models\Realestate;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class SearchList extends Component
{
    use WithPagination;

    public $filter = [
        'search' => '',
    ];

    public function updatingfilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (Auth::user()->isAdmin)
        {
            $filtered = Realestate::query()->orderBy('street')
                ->where('address','LIKE','%'. $this->filter['search'].'%')
                ->where(function (Builder $query) {$query->Visible();})
                ->paginate(20);
        }else{
            $filtered = Realestate::query()->orderBy('street')
                ->where('user_id', Auth::user()->id)
                ->where('address','LIKE','%'. $this->filter['search'].'%')
                ->where(function (Builder $query) {$query->Visible();})
                ->paginate(20);
        }
        return view('livewire.user.realestate.search-list', compact('filtered'));
    }
}
