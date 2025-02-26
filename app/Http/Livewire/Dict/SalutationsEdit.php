<?php

namespace App\Http\Livewire\Dict;

use Livewire\Component;
use App\Models\Salutation;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithCachedRows;

class SalutationsEdit extends Component
{

    use  WithCachedRows;
    public $salutations = null;

    public $filters = [
        'search' => '',
    ];


    public function mount()
    {
        $this->salutations = Salutation::all();
        Debugbar::info($this->salutations);
    }

    public function getRowsQueryProperty()
    {
        if($this->filters['search'])
        {
            $result = Salutation::query()
                ->where(function (Builder $query){
                    $query->where('bezeichnung','LIKE','%'. $this->filters['search'].'%');
                });
        } else {
            $result = Salutation::query();
        };
        return $result;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function render()
    {
        return view('livewire.dict.salutations-edit', [
            'rows' => $this->rows,
        ]);
    }
}
