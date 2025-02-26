<?php

namespace App\Models;

use App\Http\neko\Helpers;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Verbrauchsinfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nekoOccupant_id', 'occupant_id', 'art', 'einheit_id', 'nutzergrup_id', 'nutzergrup_name', 'nekoId', 'jahr_monat', 'datum', 'durchschnitt',
        'zeitraum_akt', 'zeitraum_mon', 'zeitraum_vorj', 'verbrauch_akt', 'verbrauch_mon', 'verbrauch_vorj','hk','ww', 'mess_einheit'
    ];
    
    public function occupant()
    {
        return $this->belongsTo(Occupant::class);
    }

    public function einheit()
    {
        return $this->belongsTo(Einheit::class);
    }

    public static function validateImportData($data) {
        return Validator::make($data, [
            'nekoId' => 'required|numeric',
            'nekoOccupant_id' => 'required|string|max:40',
            'art' => 'required|string|max:255',
            'einheit' => 'required|string|max:255',
            'einheit_id' => 'required|numeric',
            'nutzergrup_id' => 'required|numeric',
            'nutzergrup_name' => 'required|string|max:255',
        ]);
    }

    public function getVerbrauchAktDisplayAttribute(){
         return number_format($this->verbrauch_akt, 2, ',', '.');
    }
    public function getVerbrauchMonDisplayAttribute(){
        return number_format($this->verbrauch_mon, 2, ',', '.');
    }
    public function getVerbrauchVorjDisplayAttribute(){
        return number_format($this->verbrauch_vorj, 2, ',', '.');
    }
    
    public function getDurchschnittDisplayAttribute(){
        return number_format($this->durchschnitt, 2, ',', '.');
    }

 

}
