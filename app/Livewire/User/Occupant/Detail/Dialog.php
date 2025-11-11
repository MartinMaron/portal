<?php

namespace App\Livewire\User\Occupant\Detail;

use App\Http\Traits\Api\Job\Realestate\OccupantAdapter;
use App\Models\Occupant;
use App\Models\Realestate;
use App\Models\Salutation;
use App\Models\UnitUsageType;
use App\Rules\OcccupantDateFromGreaterPreviousRule;
use App\Rules\OccupantDateFromLessDateToRule;
use App\Http\Traits\Helper\FormatsNumbers;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Livewire\Component;

class Dialog extends Component
{
    use OccupantAdapter, FormatsNumbers;
    public $salutations = null;
    public $unitUsageTypes = null;
    public Realestate $realestate;
    public $current;
    public Occupant $initOccupant;
    // Form properties
    public $dateFromNewOccupant = null;
    public $hasLeerstand = false;
    public $mlage = '';
    public string $qmkc = '';
    public string $pe = '';
    public string $vorauszahlung = '';
    // Dialog properties
    public string $dialogMode = 'init';
    public bool $showEditModal;
    // MultiViewForm properties
    public $currentPage = 1;
    public $success;
    // Nummern-Format Mapping für Trait (property => decimals)
    protected array $numericFormatMap = [
        'current.qmkc_editing' => 2,
        'current.personen_zahl' => 2,
        'current.vorauszahlung_editing' => 2,
    ];
    public $pages = [
        1 => [
            'heading' => 'Persönliche Information',
            'subheading' => 'hier können die pesonenbezogenen Daten eingegeben werden.',
        ],
        2 => [
            'heading' => 'Adresse und Anschrift',
            'subheading' => 'Bitte die Daten vervolständigen.',
        ],
        3 => [
            'heading' => 'Eigenschaften der Nutzeinheit',
            'subheading' => 'hier können die Daten der Nutzereinheit verändert werden.',
        ],
        4 => [
            'heading' => 'Zusätzliche Bemerkungen',
            'subheading' => 'es können weitere Bemerkungen eingetragen werden.',
        ],
    ];

    private $validationRulesChange = [
        1 => [
            'dateFromNewOccupant' => ['required', 'date'],
            'hasLeerstand' => 'nullable|boolean',
            'current.nachname' => 'required_if:current.cost.consumption,==,1|nullable|min:2',
            'current.nekoId' => 'required|min:3',
            'current.nutzeinheitNo' => 'required|numeric',
            'current.realestate_id' => 'required|numeric',
            'current.budguid' => 'required|min:3',
            'current.unvid' => 'nullable',
            'current.vorname' => 'nullable',
            'current.eigentumer' => 'nullable',
            'current.anrede' => 'nullable',
            'current.address' => 'nullable',
            'current.street' => 'nullable',
            'current.city' => 'nullable',
            'current.houseNr' => 'nullable',
            'current.postcode' => 'nullable',
            'current.email' => 'nullable|string|email|max:255',
            'current.telephone_number' => 'nullable',
            'current.date_from_editing' => 'required|date',
            'current.date_to_editing' => 'nullable',
        ],
        2 => [
            'current.address' => 'nullable',
            'current.street' => 'nullable',
            'current.city' => 'nullable',
            'current.houseNr' => 'nullable',
            'current.postcode' => 'nullable',
        ],
        3 => [
            'current.qmkc_editing' => 'nullable',
            'current.uaw' => 'boolean',
            'current.vat' => 'boolean',
            'current.lokalart' => 'nullable',
            'current.customEinheitNo' => 'nullable',
            'current.lage' => 'nullable',
            'current.vorauszahlung_editing' => 'nullable',
            'current.personen_zahl' => 'nullable',
        ],
        4 => [
            'current.bemerkung' => 'nullable',
        ],
    ];

    public $messages = [
        'current.nachname' => 'bitte geben Sie einen Nachnamen ein',
    ];

    private $validationRulesEdit = [
        1 => [
            'dateFromNewOccupant' => 'nullable|date',
            'hasLeerstand' => 'nullable|boolean',
            'current.nachname' => 'required|min:2',
            'current.vorname' => 'nullable',
            'current.anrede' => 'nullable',
            'current.email' => 'nullable|string|email|max:255',
            'current.telephone_number' => 'nullable',
            'current.mobilnumber' => 'nullable',
            'current.date_from_editing' => 'required|string',
            'current.date_to_editing' => 'nullable|string',
        ],
        2 => [
            'current.address' => 'nullable',
            'current.street' => 'nullable',
            'current.city' => 'nullable',
            'current.houseNr' => 'nullable',
            'current.postcode' => 'nullable',
        ],
        3 => [
            'current.eigentumer' => 'nullable',
            'current.qmkc_editing' => 'nullable',
            'current.vorauszahlung_editing' => 'nullable',
            'current.uaw' => 'boolean',
            'current.vat' => 'boolean',
            'current.lokalart' => 'nullable',
            'current.customEinheitNo' => 'nullable',
            'current.lage' => 'nullable',
            'current.personen_zahl' => 'nullable',
        ],
        4 => [
            'current.bemerkung' => 'nullable',
        ],
    ];

    public function ValidationRules()
    {
        if ($this->dialogMode == 'edit') {
            return $this->validationRulesEdit;
        }
        if ($this->dialogMode == 'change') {
            return $this->validationRulesChange;
        }
    }

    protected $listeners = [
        'showOccupantModal' => 'showModal',
        'changeOccupantModal' => 'changeModal',
        'LageAutocompleteDisplaychanged' => 'lageModalChanged',
    ];

    public function rules()
    {
        if ($this->dialogMode == 'change') {
            return collect($this->validationRulesChange)->collapse()->toArray();
        } else {
            return collect($this->validationRulesEdit)->collapse()->toArray();
        }
    }

    /* initialization */
    public function mount()
    {
        $this->salutations = Salutation::all();
        $this->unitUsageTypes = UnitUsageType::all();
    }

    public function showModal(Occupant $occupant)
    {
        $this->current = $occupant->toArray();
        $this->realestate = $occupant->realestate;
        $this->currentPage = 1;
        $this->resetValidation();
        $this->resetErrorBag();
        $this->dialogMode = 'edit';
        $this->initOccupant = $occupant;
        $this->hasLeerstand = $occupant->leerstand;
        $this->showEditModal = true;
        
    }

    public function lageModalChanged($value)
    {
        Debugbar::info('lageModalChanged:'.$value);
        $this->current->lage = $value;
        $this->updated('current.lage');
    }

    public function updated($propertyName)
    {
        Debugbar::info('occupant.detail.dialog-updated:'.$propertyName);
        $calcRules = null;
        if ($this->dialogMode == 'change') {
            $calcRules = $this->validationRulesChange;
        } else {
            $calcRules = $this->validationRulesEdit;
        }

        $myRules = $calcRules[$this->currentPage];
        $myRules['current.date_from_editing'] = ['required', 'date', new OccupantDateFromLessDateToRule];
        $myRules['dateFromNewOccupant'] = ['required', 'date', new OcccupantDateFromGreaterPreviousRule];

        $this->validateOnly($propertyName, $myRules, $this->messages);

    // Nach Eingabe formatieren (nur bei Blur wegen wire:model.blur)
    $this->handleNumericFormatting($propertyName);
    }

    public function changeModal(Occupant $current)
    {
        $this->currentPage = 1;
        $this->resetValidation();
        $this->resetErrorBag();
        $this->dialogMode = 'change';
        $this->dateFromNewOccupant = (new Carbon)->format('d.m.Y');
        $this->hasLeerstand = false;
        $this->current = $this->makeDefaultOccupant($current)->toArray();
        $this->current['id'] = 0;    
        $this->current['dateTo'] = null;    
        $this->initOccupant = $current;
        $this->showEditModal = true;
    }

    

    public function closeModal($save)
    {
        if ($save && $this->current) {
           

            if ($this->validate($this->rules(), $this->messages)) {
                if ($this->dialogMode == 'change') {
                    $save = $this->changeOccupant($this->initOccupant, $this->current, $this->hasLeerstand, $this->dateFromNewOccupant);
                }

                if ($this->dialogMode == 'edit') {
                    $save = $this->editOccupant($this->current);

                }
                if (! $save->wasRecentlyCreated && $save->wasChanged()) {
                    // updateOrCreate performed an update
                    toast()->success('Die Details des Nutzers wurden geändert.', 'Achtung')->push();

                    return redirect(request()->header('Referer'));
                }

                if (! $save->wasRecentlyCreated && ! $save->wasChanged()) {
                    // updateOrCreate performed nothing, row did not change
                    $this->showEditModal = false;
                }

                if ($save->wasRecentlyCreated) {
                    // updateOrCreate performed create
                    toast()->success('Nutzerwechsel durchgeführt.', 'Achtung')->push();

                    return redirect(request()->header('Referer'));
                }

            } else {
                /* validierung war nicht erfolgreich */
                $this->showEditModal = true;
            }
        } else {
            $this->showEditModal = false;
        }

    }

    public function goToNextPage()
    {
        $calcRules = null;
        if ($this->dialogMode == 'change') {
            $calcRules = $this->validationRulesChange;
        } else {
            $calcRules = $this->validationRulesEdit;
        }

        $myRules = $calcRules[$this->currentPage];

        // custom validation
        if ($this->currentPage == 1 && $this->dialogMode == 'change') {
            $myRules['dateFromNewOccupant'] = ['required', 'date', new OcccupantDateFromGreaterPreviousRule];
        }

        if ($this->currentPage == 1 && $this->dialogMode == 'edit') {
            $myRules['current.date_from_editing'] = ['required', 'date', new OccupantDateFromLessDateToRule];
        }

        $this->validate($myRules);

        if ($this->hasLeerstand) {
            if ($this->currentPage == 1) {
                $this->currentPage = 4;
            }
        } else {
            $this->currentPage++;
        }

    }

    public function goToPreviousPage()
    {
        if ($this->hasLeerstand) {
            if ($this->currentPage == 4) {
                $this->currentPage = 1;
            }
        } else {
            $this->currentPage--;
        }
    }

    public function resetSuccess()
    {
        $this->reset('success');
    }

    public function setCurrent(Occupant $occupant)
    {
        $this->useCachedRows();
        if ($this->current->isNot($occupant)) {
            $this->current = $occupant;

        }
    }

    public function render()
    {
        return view('livewire.user.occupant.detail.dialog');
    }
}
