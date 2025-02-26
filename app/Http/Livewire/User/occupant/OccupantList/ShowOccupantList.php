<?php

namespace App\Http\Livewire\User\Occupant\OccupantList;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Occupant;
use App\Models\Realestate;
use App\Models\Salutation;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Models\UserVerbrauchsinfoAccessControl;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class ShowOccupantList extends Component
{

    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows, WithPagination;
    use \App\Http\Traits\Helpers;

    public $hasAnyCustomEinheitNo = false;
    public $nummer_display = '';
    public $hasAnyEigentumer = false;
    public $hasVat = false;
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showFilters = false;
    public $prepaidtype = true;
    public $prepaidnet = false;
    public bool $editVorauszahlungen = false;
    public $currentVorauszahlung = 0;
    public $salutations = null;
    public $filters = [
        'search' => '',
    ];

    public $dateFrom = null;

    public Occupant $current;
    public Realestate $realestate;
    public $occupant;

    protected $queryString = ['sorts'];

    public function rules() { return [
        'realestate.occupant_number_mode' => 'nullable',
        'realestate.occupant_name_mode' => 'nullable',
        'realestate.eingabeCostNetto'  => 'nullable',
        'realestate.prepaidtype' => 'nullable',];
    }

    protected $listeners = [
        'refreshParent' => '$refresh',
        'deleteConfirmed' => 'delete',      
        'confirmNekoMessage' => 'confirmNekoMessage',
    ];

    public function deleteOccupant($objectId)
    {
        $object = Occupant::find($objectId);

        /* der Zeitraum des letzen Nutzers wird wieder aufgemacht */
        $last_occupant = $object->realestate->occupants
                            ->where('nutzeinheitNo', $object->nutzeinheitNo)
                            ->where('unvid','!=', $object->unvid)
                            ->sortBy('dateFrom')->last();
        $last_occupant->dateTo = null;
        $last_occupant->save();              

        /* userEmails öffnen */
        $q = $last_occupant->realestate->verbrauchsinfoUserEmails->
            where('nutzeinheitNo', '=', $object->nutzeinheitNo)
            ->where('dateTo',(new carbon($object->dateFrom))->addDay(-1));

        foreach ($q as $userEmail) {
            $userEmail->dateTo = null;
            $userEmail->save();
            /* TODO: berechtigungen anpassen */
            /* schleife über die letzen 13 Monate und schauen userVerbrauchsinfoAccessControls neu angelegt werden müssen   */ 
            /* $last_occupant->userVerbrauchsinfoAccessControls */
            $occupantUser = User::where('email', $userEmail->email)->firstOrFail();
            for($i=0; $i < 12; $i++) {
                $jahr_monat = carbon::now()->addMonth(0-$i)->isoFormat('YYYY-M');
                $qAccContr = $last_occupant->userVerbrauchsinfoAccessControls->where('jahr_monat', $jahr_monat)
                                                                ->where('user_id', $occupantUser->id);

                if ($qAccContr->count() == 0){
                    UserVerbrauchsinfoAccessControl::updateOrcreate(
                        ['jahr_monat' => $jahr_monat, 'user_id' => $occupantUser->id,'occupant_id' => $last_occupant->id],
                        [
                            'neko_id' => 0,
                            'toWebDelete' => true,
                        ]
                    );  
                }                                                
            } 
        } 

        $object->delete();
        toast()->success('Nutzer wurde gelöscht','Achtung')->push();
    }

    public function Salutations()
    {

    }

    
    /* initialization */
    public function mount($baseobject)
    {
        $this->realestate = $baseobject;
        $this->hasAnyCustomEinheitNo = (bool) $this->realestate->occupants->where('customEinheitNo', '<>', '')->count();
        $this->hasAnyEigentumer = (bool) $this->realestate->occupants->where('eigentumer', '<>', '')->count();
        $this->hasVat = (bool) $this->realestate->occupants->where('vat', '=', '1')->count();
        $this->salutations = Salutation::all();
        $this->prepaidnet = $this->realestate->eingabeCostNetto;
        $this->sorts = [
            'unvid' => 'asc'
            ];
        $this->current = $this->realestate->occupants->first();
        $this->editVorauszahlungen = !$this->realestate->abrechnungssetting->nutzerlisteDone;
    }

    public function toggle($value)
    {
        if ($value == 'filters') {
            $this->useCachedRows();
            $this->showFilters = !$this->showFilters;
        }
        if ($value == 'vorauszahlung') {
            $this->editVorauszahlungen = !$this->editVorauszahlungen;
        }
        if ($value == 'nummer'){
            $this->realestate->save();
        }
        if ($value == 'eigentumer'){
            $this->realestate->save();
        }
        if ($value == 'prepaidtype'){
            $this->prepaidtype = !$this->prepaidtype;
            if($this->prepaidtype){
                $this->realestate->prepaidtype = 'H';
            }else{
                $this->realestate->prepaidtype = 'B';
            }
            $this->realestate->save();
        }
        if ($value == 'prepaidnet'){
            $this->prepaidnet = !$this->prepaidnet;
            $this->realestate->eingabeCostNetto = $this->prepaidnet;
            $this->realestate->save();
        }
    }

    public function setDone()
    {
        $this->emit('showNekoMessageModal',['title'=>'Nutzerliste absenden?','message'=>'Dannach können keine Änderungen mehr vorgenommen werden.','type'=>'warning','action'=>'confirmEditDone']);
    }
    public function emit_QuestionDeleteModal(Occupant $id)
    {
        $this->emit('showNekoMessageModal',['title'=>'Löschen bestätigen?','message'=>'Wollen Sie den Nutzer '.  $id->nachname .  ' entfernen?','type'=>'delete','action'=>'deleteOccupant','id'=>$id->id]);
    }

    public function confirmNekoMessage($params)
    {
        $this->params = $params;
        if ($this->params['action'] == 'confirmEditDone') {
            $this->realestate->abrechnungssetting->nutzerlisteDone = 1;
            $this->realestate->abrechnungssetting->save();
            $this->editVorauszahlungen = !$this->realestate->abrechnungssetting->nutzerlisteDone;
            return redirect(request()->header('Referer'));
        }
        if ($this->params['action'] == 'deleteOccupant') {
            $this->deleteOccupant($this->params['id']);
            return redirect(request()->header('Referer'));
        }
    }

    public function change(Occupant $occupant)
    {
        $this->setCurrent($occupant);
        $this->emit('changeOccupantModal', $occupant);
    }

    public function setCurrent(Occupant $occupant)
    {
         $this->useCachedRows();
        if ($this->current->isNot($occupant)) {
            $this->current = $occupant;
            $this->currentVorauszahlung = $occupant->vorauszahlung;
        }
    }

    public function edit(Occupant $occupant)
    {
        $this->setCurrent($occupant);
        $this->emit('showOccupantModal', $this->current);
        
    }

    public function confirmPrePaid(Occupant $occupant, $value)
    {
        $this->useCachedRows();
        if ($this->current->isNot($occupant)) $this->current = $occupant;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function updatingfilter()
    {
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        if ($this->filters['search']) {
            $result = Occupant::query()
                ->where('realestate_id', '=', $this->realestate->id)
                ->where(function (Builder $query) {
                    $query->where('address', 'LIKE', '%' . $this->filters['search'] . '%')
                        ->orWhere('lage', 'LIKE', '%' . $this->filters['search'] . '%')
                        ->orWhere('customEinheitNo', 'LIKE', '%' . $this->filters['search'] . '%')
                        ->orWhere('eigentumer', 'LIKE', '%' . $this->filters['search'] . '%' )
                        ->orWhere('nachname', 'LIKE', '%' . $this->filters['search'] . '%' )
                        ->orWhere('unvid', 'LIKE', '%' . $this->filters['search'] . '%');
                });
        } else {
            $result = Occupant::query()
                ->where('realestate_id', '=', $this->realestate->id);
        };


        $this->applySorting($result);
        return $result;
    }

    public function getRowsProperty()
    {
        // return $this->cache(function () {
        return $this->rowsQuery->paginate(20);
        // });
    }

    public function render()
    {

        return view('livewire.user.occupant.occupant-list.show-occupant-list', [
            'rows' => $this->rows,
            'salutations' => $this->salutations(),
            'current' => $this->current,
        ]);
    }
}
