<?php

namespace App\Models;

use App\Models\Cost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\Abrechnungssetting;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Realestate extends Model
{
    use HasFactory;
    use SoftDeletes;



    public function scopeVisible($query)
    {
        $query->where('heizkosten', 1)
                ->orWhere('miete', 1)
                ->orWhere('rauchmelder', 1) ;
    }

    protected $fillable = [
        'nekoId', 'email', 'unvid', 'address', 'street', 'postCode','city','heizkosten','rauchmelder','miete',
        'user_id', 'eingabeCostNetto', 'eingabeCostOhneDatum', 'occupant_name_mode', 'occupant_number_mode',
        'abrechnungssetting_id','kosteneingabe','nutzerlisteDone', 'heizkostenlisteDone','betreibskostenDone'
    ];

    protected $appends = [
            'has_occupants_different_adresses',
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
        return $this->hasMany(Costkey::class);
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
        return  Validator::make($data, [
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

    protected function getHasOccupantsDifferentAdressesAttribute(){
        $qoccp = $this->occupants()->get();
        
        $occp = $qoccp->unique('street');
        if($occp->count()!=1){ return true;}
       
        $occp = $qoccp->unique('city');
        if($occp->count()!=1){ return true;}

        $occp = $qoccp->unique('postcode');
        if($occp->count()!=1){ return true;}

        $occp = $qoccp->unique('houseNr');
        if($occp->count()!=1){ return true;}
        
        return false;
    }
}
