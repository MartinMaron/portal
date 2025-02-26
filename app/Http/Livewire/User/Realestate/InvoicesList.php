<?php

namespace App\Http\Livewire\User\Realestate;

use Livewire\Component;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Livewire\DataTable\WithSorting;



class InvoicesList extends Component
{

    use  WithSorting;

    public $realestate;
    public $filters = [
        'search' => '',
    ];

    public function mount($realestate)
    {
        $this->realestate->$realestate;
        $this->sorts = [
            'createDate' => 'desc',
            'caption' => 'asc'
            ];
    }


    
    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getRowsQueryProperty()
    {
        if ($this->filters['search']) {
            $result = Invoice::query()
                ->where('realestate_id', '=', $this->realestate->id)
                ->where(function (Builder $query) {
                    $query->where('caption', 'LIKE', '%' . $this->filters['search'] . '%')
                        ->orWhere('fileName', 'LIKE', '%' . $this->filters['search'] . '%')
                        ->orWhere('createDate', 'LIKE', '%' . $this->filters['search'] . '%')
                        ->orWhere('description', 'LIKE', '%' . $this->filters['search'] . '%');
                });
        } else {
            $result = Invoice::query()
                ->where('realestate_id', '=', $this->realestate->id);
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

        public function render()
        {
        return view('livewire.user.realestate.invoices-list', ['invoices' => $this->rows]);
    }
}
