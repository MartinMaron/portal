<?php   

namespace App\Livewire\User\CostAmount;

use App\Models\CostAmount;
use App\Http\Traits\Helper\FormatsNumbers;
use Livewire\Component;

class Detail extends Component
{
    use FormatsNumbers;
    public CostAmount $costAmount;
    public $visible = false;
    public $current = [];
    public $dialogMode = 'init';

    public function mount()
    {
        $this->costAmount = $this->makeBlankObject();
    }

    protected $listeners = [
        'showCostAmountDetailModal' => 'showModal',
    ];

    public function updated($property)
    {
        $this->handleNumericFormatting($property);
    }


#region formatierung der Eingabefelder nach der Eingabe

     /**
     * Zu formatierende numerische Felder (property => Nachkommastellen)
     */
    protected array $numericFormatMap = [
        'current.consumption_editing' => 1,
        'current.netto' => 2,
        'current.brutto' => 2,
        'current.haushaltsnah' => 2,
        'current.grosAmount_HH' => 2,
        'current.coconsupmtion' => 0,
        'current.conetto' => 2,
        'current.cobrutto' => 2,
    ];

    /**
     * Reagiert auf Feldänderungen (blur) und formatiert definierte Zahlenfelder.
     */
    

    // normalizeNumber & formatNumber via FormatsNumbers trait

#endregion

    public function rules()
    {
        return [
            'current.bemerkung' => 'nullable',
            'current.description' => 'nullable',
            'current.consumption_editing' => 'required_if:current.cost.consumption,==,1|nullable',
            'current.netto' => 'nullable',
            'current.haushaltsnah' => 'nullable',
            'current.brutto' => 'required',
            'current.grosAmount_HH' => 'nullable',
            'current.cobrutto' => 'nullable',
            'current.conetto' => 'nullable',
            'current.coconsupmtion' => 'nullable',
            'current.datum' => 'required_if:current.cost.fueltype.hasTank,==,1|date|nullable',
        ];
    }

    public function messages()
    {
        return [
            'current.datum' => ':attribute muss angegeben werden',
            'current.consumption_editing' => ':attribute muss angegeben werden',
        ];
    }

    public function attributes()
    {
        return [
            'current.datum' => 'Datum',
            'current.consumption_editing' => 'Verbrauch',
        ];
    }

    public function showModal(CostAmount $costAmount)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->costAmount = $costAmount;
        $this->current = $costAmount->toArray();
        $this->current['cost'] = $costAmount->cost;
        $this->dialogMode = 'edit';
        $this->visible = true;
    }

    public function closeModal($save)
    {
        if ($save && $this->costAmount) {
            if ($this->validate($this->rules(), $this->messages(), $this->attributes())) {
                $this->costAmount->save();
                $this->visible = false;
                $this->resetErrorBag();
                $this->resetValidation();
                $this->dispatch('refreshComponents');
            } else {
                $this->visible = true;
            }
        } else {
            $this->visible = false;
            $this->resetErrorBag();
            $this->resetValidation();
        }
    }

    public function render()
    {
        return view('livewire.user.costamount.detail');
    }
}
