<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Realestate extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function scopeVisible($query)
    {
        $query->where('heizkosten', 1)
            ->orWhere('miete', 1)
            ->orWhere('betriebskosten', 1)
            ->orWhere('rauchmelder', 1);
    }

    protected $fillable = [
        'nekoId',
        'email',
        'unvid',
        'address',
        'street',
        'postCode',
        'city',
        'heizkosten',
        'rauchmelder',
        'miete',
        'user_id',
        'eingabeCostNetto',
        'eingabeCostOhneDatum',
        'occupant_name_mode',
        'occupant_number_mode',
        'abrechnungssetting_id',
        'kosteneingabe',
        'nutzerlisteDone',
        'heizkostenlisteDone',
        'betreibskostenDone',
    ];

    protected $appends = [
        'has_occupants_different_adresses',
    ];

    protected $casts = [
        'eingabeCostNetto' => 'boolean',
        'eingabeCostDatum' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function occupants()
    {
        return $this->hasMany(Occupant::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function costskeys()
    {
        return $this->hasMany(CostKey::class);
    }

    public function abrechnungssettings()
    {
        return $this->hasMany(Abrechnungssetting::class);
    }

    public function abrechnungssetting()
    {
        return $this->belongsTo(Abrechnungssetting::class);
    }

    public function verbrauchsinfoUserEmails()
    {
        return $this->hasMany(VerbrauchsinfoUserEmail::class);
    }

    public static function validateImportData($data)
    {
        return Validator::make($data, [
            'nekoId' => 'required|string|max:40',
            'email' => 'required|string|email|max:255',
            'unvid' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'postCode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date',
            'heizkosten' => 'required|boolean',
            'rauchmelder' => 'required|boolean',
            'miete' => 'required|boolean',
        ]);
    }

    protected function getHasOccupantsDifferentAdressesAttribute()
    {
        $qoccp = $this->occupants()->get();

        $occp = $qoccp->unique('street');
        if ($occp->count() != 1) {
            return true;
        }

        $occp = $qoccp->unique('city');
        if ($occp->count() != 1) {
            return true;
        }

        $occp = $qoccp->unique('postcode');
        if ($occp->count() != 1) {
            return true;
        }

        $occp = $qoccp->unique('houseNr');
        if ($occp->count() != 1) {
            return true;
        }

        return false;
    }


    public function hasAbrechnung(): bool
    {
        $referenceDate = Carbon::now();
        $lastSettings = $this->abrechnungssettings()
            ->orderByDesc('periodTo')
            ->first();

        /* es gibt keine Einstellungen --- IGNORE --- */
        if (!$lastSettings) {return false;}

     
        if ($lastSettings->periodTo->isBefore($referenceDate)) {
            /* keine neue Einstelleung existiert */
            return ($lastSettings->hk_id != null && $lastSettings->hk_id != '00000000-0000-0000-0000-000000000000')   ||   ($lastSettings->bk_id != null && $lastSettings->bk_id != '00000000-0000-0000-0000-000000000000');
        }else{
            /* neue Einstelleung existiert */
            $currentSettings = $lastSettings;
            $prevSettings = $this->abrechnungssettings()
                ->where('id', '<>', $currentSettings->id)
                ->orderByDesc('periodTo')
                ->first();
            if (!$prevSettings) {return false;}

            $currentSettingsDate = Carbon::parse($currentSettings->periodFrom);
            $currentSettingsDate = $currentSettingsDate->addDays(-1); /* aktuelle Einstelleung beginnt am nächsten Tag nach der letzten Einstelleung */
            /* letzte und aktuelle Periode hat keine zeitliche Lücke */
            if ($currentSettingsDate == $prevSettings->periodTo) {
                /* aktuelle Einstelleung beginnt in der Zukunft */
                return $prevSettings->hk_id != null || $prevSettings->bk_id != null;
            }else{
                /* aktuelle Einstelleung beginnt in der Vergangenheit */
                return false;   
            }
            
        }
    }

    public function inWorkAbrechnung(): bool
    {
       

        $referenceDate = Carbon::now();
        $lastSettings = $this->abrechnungssettings()
            ->orderByDesc('periodTo')
            ->first();

        /* es gibt keine Einstellungen --- IGNORE --- */
        if (!$lastSettings) {
            return false;
        }

        /* wenn noch keine neue Einstellung existiert (dann ist die abrechnung nicht fertig) */
        if ($lastSettings->periodTo->isBefore($referenceDate)) {
            if ($this->kosteneingabe) {
                if ($this->heizkosten == 1 && !$lastSettings->heizkostenlisteDone) {
                        return false;
                    }

                if ($this->heizkosten == 1 && !$lastSettings->brennstofflisteDone) {
                        return false;
                    }

                if ($this->betriebskosten == 1 && !$lastSettings->betreibskostenDone) {
                        return false;
                    }
            }
            if ($this->nutzerlisteactive && !$lastSettings->nutzerlisteDone) {                
                return false;                
            }
        }
        return  ! $this->hasAbrechnung() && ($this->noAbrechnung() === false);
    }
    public function noAbrechnung(): bool
    {
        if ($this->betriebskosten || $this->heizkosten) {
            return false;
        }else{
            return true;    
        }
    }

}
