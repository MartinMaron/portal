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
        'search' => null,
        'status' => 'all', // all, has_abrechnung, in_work, other
    ];

    public function updatingfilter()
    {
        $this->resetPage();
    }

    public function realestatesCount()
    {
        $query = Realestate::query()->where('user_id', Auth::user()->id);
        return $query->count();
    }


    public function render()
    {
        $query = Realestate::query()->orderBy('street');

        if (!Auth::user()->isAdmin) {
            $query->where('user_id', Auth::user()->id);
        }

        $query->where(function ($q) {
            $q->where('address', 'LIKE', '%' . $this->filter['search'] . '%')
                ->orWhere('street', 'LIKE', '%' . $this->filter['search'] . '%')
                ->orWhere('city', 'LIKE', '%' . $this->filter['search'] . '%');
        });

        $query->where(function (Builder $query) {
            $query->Visible();
        });

        // 1. Get all candidates that match the basic search & permissions
        $allCandidates = $query->get();

        // 2. Filter in Memory using the Model functions
        $filteredCollection = $allCandidates->filter(function ($realestate) {
            $statusFilter = $this->filter['status'] ?? 'all';

            if ($statusFilter === 'all') {
                return true;
            }

            if ($statusFilter === 'has_abrechnung') {
                return $realestate->hasAbrechnung() === true;
            }

            if ($statusFilter === 'in_work') {
                return $realestate->inWorkAbrechnung() === true && ($realestate->noAbrechnung() === false);
            }

            if ($statusFilter === 'other') {
                return ($realestate->hasAbrechnung() === false && $realestate->inWorkAbrechnung() === false) && ($realestate->noAbrechnung() === false);
            }

            return true;
        });

        // 3. Manual Pagination
        $perPage = 20;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $currentPageItems = $filteredCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $filtered = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $filteredCollection->count(),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'pageName' => 'page']
        );

        return view('livewire.user.realestate.search-list', compact('filtered'));
    }
}
