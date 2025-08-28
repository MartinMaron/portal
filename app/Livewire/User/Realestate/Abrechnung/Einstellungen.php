<?php

namespace App\Livewire\User\Realestate\Abrechnung;

use App\Models\Realestate;
use Livewire\Component;

class Einstellungen extends Component
{
    public $realestate;
    public $einstellungen;
    public Realestate $baseobject;

    public function mount(Realestate $baseobject)
    {
        $this->baseobject = $baseobject;
        $this->realestate = $baseobject->toArray();
        $this->einstellungen = $baseobject->abrechnungssetting->toArray();
    }

    public function updated($propertyName)
    {
        if ($this->validateOnly($propertyName)) {
            if (str_starts_with($propertyName, 'realestate.')) {
                $key = str_replace('realestate.', '', $propertyName);
                $this->baseobject->{$key} = $this->realestate[$key];
                $this->baseobject->save();
            }
            if (str_starts_with($propertyName, 'einstellungen.')) {
                $key = str_replace('einstellungen.', '', $propertyName);
                $this->baseobject->abrechnungssetting->{$key} = $this->einstellungen[$key];
                $this->baseobject->abrechnungssetting->save();
            }
        }
    }

    public function rules()
    {
        return [
            'realestate.eingabeCostNetto' => 'nullable',
            'realestate.eingabeCostDatum' => 'nullable',
            'einstellungen.stromkosten' => 'numeric',
            'einstellungen.nabi_inhaber' => 'nullable',
            // IBAN nach allgemeinem Muster: 2 Buchstaben, 2 Ziffern + 10-30 alphanum. Zeichen
            'einstellungen.nabi_nr' => ['nullable','string', function($attribute,$value,$fail){
                if ($value === null || $value === '') { return; }
                $iban = strtoupper(preg_replace('/\s+/','',$value));
                if (!preg_match('/^[A-Z]{2}[0-9]{2}[A-Z0-9]{10,30}$/',$iban)) {
                    return $fail('Die IBAN hat ein ungültiges Format.');
                }
                // Mod-97 Check
                $rearranged = substr($iban,4) . substr($iban,0,4);
                $expanded = '';
                foreach(str_split($rearranged) as $ch){
                    $expanded .= ctype_alpha($ch) ? (ord($ch) - 55) : $ch; // A=10 ... Z=35
                }
                // chunkweise modulo 97 berechnen um Überlauf zu vermeiden
                $mod = 0;
                foreach(str_split($expanded,9) as $chunk){
                    $mod = intval($mod . $chunk) % 97;
                }
                if ($mod !== 1) {
                    return $fail('Die IBAN Prüfziffer ist ungültig.');
                }
            }],
            'einstellungen.co2_kennzeichen_WEG' => 'nullable',
            'einstellungen.co2_wohngeb' => 'nullable',
            'einstellungen.co2_kennzeichen_1_9' => 'nullable',
            'einstellungen.co2_kennzeichen_2_9' => 'nullable',
            'einstellungen.co2_anschluss_nach_2022' => 'nullable',
        ];
    }

    public function render()
    {
        return view('livewire.user.realestate.abrechnung.einstellungen');
    }
}
