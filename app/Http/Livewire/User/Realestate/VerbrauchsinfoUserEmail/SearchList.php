<?php

namespace App\Http\Livewire\User\Realestate\VerbrauchsinfoUserEmail;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Realestate;
use App\Models\Occupant;
use App\Models\VerbrauchsinfoUserEmail;
use App\Http\Livewire\DataTable\WithSorting;
use Usernotnull\Toast\Concerns\WireToast;

class SearchList extends Component
{
    use WithSorting, WireToast;
    public Realestate $realestate;
    public VerbrauchsinfoUserEmail $currentUserEmail;
    
    public $filter = [
        'search' => null,
    ];

    public function mount($realestate)
    {
        $this->realestate = $realestate;
        $this->sorts = ['nutzeinheitNo' => 'asc'];
    }

    protected $listeners = [
        'refreshParent' => '$refresh',
        'deleteConfirmed' => 'delete',
        'createUserEmailModal' => 'createUserEmailModal'
    ];

    public function delete($objectId, $objectType)
    {
        if ($objectType != 'VerbrauchsinfoUserEmail') return;
        $object = VerbrauchsinfoUserEmail::find($objectId);
        $object->delete();
        toast()->success('Emailadresse für Verbraucherinformationen gelöscht','Achtung')->push();
    }

    public function rules()
    {
        return [
            'userEmail.email' => 'required|string|email|max:255',
            'userEmail.firstinitUsername' => 'nullable',
            'userEmail.nutzeinheitNo' => 'required',
            'userEmail.realestate_id' => 'required',
        ];
    }

    public function makeBlankObject(Occupant $occupant)
    {
        $ret_val = VerbrauchsinfoUserEmail::make([
            'realestate_id' => $this->realestate->id,
            'occupant_id' => $occupant->id,
            'anonym' => false,
            'nutzeinheitNo'=> $occupant->nutzeinheitNo,
            'email' => 'info@e-neko.de',
        ]);
        return $ret_val;
    }

    public function createUserEmailModal($occupant){
        $this->currentUserEmail = $this->makeBlankObject($occupant);
        $this->emit('showCreateUserEmailModal', $this->currentUserEmail);
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function getRowsQueryProperty()
    {
        $result = $this->realestate->occupants();
        return $this->applySorting($result);
    }

    public function raise_CreateVerbrauchsinfoUserEmailModal(Occupant $occupant)
    {
        $this->createUserEmailModal($occupant);
    }

    public function render()
    {
        $occupants = $this->rowsQuery
        ->where('nachname','LIKE','%'. $this->filter['search'].'%')
        ->get();

        return view('livewire.user.realestate.verbrauchsinfo-user-email.search-list', [
            'rows' => $this->rows,
            'occupants' => $occupants,
        ]);
    }
}



