<?php

namespace App\Livewire\User\Occupant\OccupantList;

use App\Http\Traits\Helpers;
use App\Livewire\DataTable\WithBulkActions;
use App\Livewire\DataTable\WithCachedRows;
use App\Livewire\DataTable\WithPerPagePagination;
use App\Livewire\DataTable\WithSorting;
use App\Models\Occupant;
use App\Models\Realestate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserVerbrauchsinfoAccessControl;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\Helper\RealestateHelper;

class ShowOccupantList extends Component
{
    use Helpers;
    use RealestateHelper;
    use WithBulkActions, WithCachedRows, WithPagination, WithPerPagePagination, WithSorting;
    use WithFileUploads;

    public bool $editable = false;
    public Realestate $realestate;
    public $current;
    public $filters;
   
    public $prepaids = [];
    public $personCounts = [];

    public function rules()
    {
        return [
            'realestate.occupant_number_mode' => 'nullable',
            'realestate.occupant_name_mode' => 'nullable',
            'realestate.eingabeCostNetto' => 'nullable',
            'realestate.prepaidtype' => 'nullable', ];
    }

    protected $listeners = [
        'refreshParent' => '$refresh',
        'deleteConfirmed' => 'delete',
        'confirmNekoMessage' => 'confirmNekoMessage',
        'uploadPhoto' => 'uploadPhoto'
    ];

    public function deleteOccupant($objectId)
    {
        $object = Occupant::find($objectId);

        /* der Zeitraum des letzen Nutzers wird wieder aufgemacht */
        $last_occupant = $object->realestate->occupants
            ->where('nutzeinheitNo', $object->nutzeinheitNo)
            ->where('unvid', '!=', $object->unvid)
            ->sortBy('dateFrom')->last();
        $last_occupant->dateTo = null;
        $last_occupant->save();

        /* userEmails öffnen */
        $q = $last_occupant->realestate->verbrauchsinfoUserEmails->
            where('nutzeinheitNo', '=', $object->nutzeinheitNo)
                ->where('dateTo', (new carbon($object->dateFrom))->addDay(-1));

        foreach ($q as $userEmail) {
            $userEmail->dateTo = null;
            $userEmail->save();
            /* TODO: berechtigungen anpassen */
            /* schleife über die letzen 13 Monate und schauen userVerbrauchsinfoAccessControls neu angelegt werden müssen */
            /* $last_occupant->userVerbrauchsinfoAccessControls */
            $occupantUser = User::where('email', $userEmail->email)->firstOrFail();
            for ($i = 0; $i < 12; $i++) {
                $jahr_monat = carbon::now()->addMonth(0 - $i)->isoFormat('YYYY-M');
                $qAccContr = $last_occupant->userVerbrauchsinfoAccessControls->where('jahr_monat', $jahr_monat)
                    ->where('user_id', $occupantUser->id);

                if ($qAccContr->count() == 0) {
                    UserVerbrauchsinfoAccessControl::updateOrcreate(
                        ['jahr_monat' => $jahr_monat, 'user_id' => $occupantUser->id, 'occupant_id' => $last_occupant->id],
                        [
                            'neko_id' => 0,
                            'toWebDelete' => true,
                        ]
                    );
                }
            }
        }

        $object->delete();
        toast()->success('Nutzer wurde gelöscht', 'Achtung')->push();
    }

    public function Salutations() {}

    /* initialization */
    public function mount($realestate)
    {
        $this->realestate = $realestate;
        $this->current = $this->realestate->toArray();
        $this->sorts = ['unvid' => 'asc'];
        $this->editable = !$this->realestate->abrechnungssetting->nutzerlisteDone;
        $this->filters = ['search' => ''];

        foreach ($this->rows as $occupant) {
            $this->personCounts[$occupant->id] = $occupant->personenZahl;
        }
        $this->reloadPrepaids();
    }

    protected function reloadPrepaids()
    {
        foreach ($this->rows as $occupant) {
            $this->prepaids[$occupant->id] = $occupant->vorauszahlungEditing;
        }
    }

    public function updatedPersonCounts($value, $key)
    {
        $this->realestate->occupants->find($key)->personenZahl = $this->castStringToDouble($value);
        $this->personCounts[$key] = number_format(floatval(str_replace(',', '.', str_replace('.', '', $value))), 2, ',', '.');
    }

    public function updatedPrepaids($value, $key)
    {
        $this->realestate->occupants->find($key)->vorauszahlungEditing = $value;
        $this->prepaids[$key] = number_format(floatval(str_replace(',', '.', str_replace('.', '', $value))), 2, ',', '.');
    }

    public function toggle($value)
    {
        if ($value == 'nummer') {
            $this->realestate->occupant_number_mode = $this->current['occupant_number_mode'];
            $this->realestate->save();
        }
        if ($value == 'eigentumer') {
            $this->realestate->occupant_name_mode = $this->current['occupant_name_mode'];
            $this->realestate->save();
        }
        if ($value == 'prepaidtype') {
            $this->realestate->prepaidtype = $this->current['prepaidtype'];
            $this->realestate->save();
            $this->reloadPrepaids();
        }
        if ($value == 'eingabeCostNetto') {
            $this->realestate->eingabeCostNetto = $this->current['eingabeCostNetto'];
            $this->realestate->save();
            $this->reloadPrepaids();
        }
    }

    public function setDone()
    {
        $this->dispatch('showNekoMessageModal', ['title' => 'Nutzerliste absenden?', 'message' => 'Dannach können keine Änderungen mehr vorgenommen werden.', 'type' => 'warning', 'action' => 'confirmEditDone']);
    }

    public function emit_QuestionDeleteModal(Occupant $id)
    {
        $this->dispatch('showNekoMessageModal', ['title' => 'Löschen bestätigen?', 'message' => 'Wollen Sie den Nutzer '.$id->nachname.' entfernen?', 'type' => 'delete', 'action' => 'deleteOccupant', 'id' => $id->id]);
    }

    public function confirmNekoMessage($params)
    {
        $this->params = $params;
        if ($this->params['action'] == 'confirmEditDone') {
            $this->realestate->abrechnungssetting->nutzerlisteDone = 1;
            $this->realestate->abrechnungssetting->save();
            $this->editable = ! $this->realestate->abrechnungssetting->nutzerlisteDone;
            return redirect(request()->header('Referer'));
        }
        if ($this->params['action'] == 'deleteOccupant') {
            $this->deleteOccupant($this->params['id']);

            return redirect(request()->header('Referer'));
        }
    }

    public function change(Occupant $occupant)
    {
        $this->dispatch('changeOccupantModal', $occupant);
    }

    public function edit(Occupant $occupant)
    {
        $this->dispatch('showOccupantModal', $occupant);
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    // Livewire Hook: wird ausgelöst wenn irgendein Feld in $filters geändert wird
    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        if ($this->filters['search']) {
            $result = Occupant::query()
                ->where('realestate_id', '=', $this->realestate->id)
                ->where(function (Builder $query) {
                    if ($this->realestate->abrechnungssetting != null) {
                        $query->where('dateFrom', '<=', $this->realestate->abrechnungssetting->periodTo)
                            ->orWhere('dateTo', '=', null);
                    }
                })
                ->where(function (Builder $query) {
                    if ($this->realestate->abrechnungssetting != null) {
                        $query->where('dateTo', '=', null)
                            ->orWhere('dateTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                    }
                })
                ->where(function (Builder $query) {
                    $query->where('address', 'LIKE', '%'.$this->filters['search'].'%')
                        ->orWhere('lage', 'LIKE', '%'.$this->filters['search'].'%')
                        ->orWhere('customEinheitNo', 'LIKE', '%'.$this->filters['search'].'%')
                        ->orWhere('eigentumer', 'LIKE', '%'.$this->filters['search'].'%')
                        ->orWhere('nachname', 'LIKE', '%'.$this->filters['search'].'%')
                        ->orWhere('unvid', 'LIKE', '%'.$this->filters['search'].'%');
                });
        } else {
            $result = Occupant::query()
                ->where('realestate_id', '=', $this->realestate->id)
                ->where(function (Builder $query) {
                    if ($this->realestate->abrechnungssetting != null) {
                        $query->where('dateFrom', '<=', $this->realestate->abrechnungssetting->periodTo)
                            ->orWhere('dateTo', '=', null);
                    }
                })
                ->where(function (Builder $query) {
                    if ($this->realestate->abrechnungssetting != null) {
                        $query->where('dateTo', '=', null)
                            ->orWhere('dateTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                    }
                });
        }
        $this->applySorting($result);
        return $result;
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(20);
    }

    public $uploadedPhotoUrl;

    public function uploadPhoto($imageData)
    {
        // Base64-Daten verarbeiten
        $imageData = explode(',', $imageData)[1];
        $image = base64_decode($imageData);

        // Speichern in DigitalOcean Spaces
        $filename = 'photo_' . time() . '.png';
        $this->uploadedPhotoUrl = Storage::disk('spaces')->put('uploads/' . $filename, $image, 'public');


        // URL speichern und anzeigen
        $this->uploadedPhotoUrl = Storage::disk('spaces')->url('uploads/' . $filename);


        Debugbar::info($this->uploadedPhotoUrl);

    }



    public $photo; // Hochgeladene Datei

    public function uploadPhotoDisc()
    {

        // Überprüfe, ob eine Datei hochgeladen wurde
        $this->validate([
            'photo' => 'image|max:1024', // Maximalgröße: 1MB
        ]);

        // Speichern der Datei auf DigitalOcean Spaces
        // $path = $this->photo->store('uploads', 'spaces');

        $path = Storage::disk('spaces')->put('uploads_1', $this->photo, 'public');



        // URL der hochgeladenen Datei speichern
        //$this->uploadedPhotoUrl = Storage::disk('spaces')->url($path);
    }


  
  
    public function render()
    {
    return view('livewire.user.occupant.occupant-list.show-occupant-list');
    }
}
