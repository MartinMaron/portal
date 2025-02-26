<?php

namespace App\Models;
use Carbon\Carbon;
use App\Http\Traits\Helpers;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\VerbrauchsinfoCounterMeter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Occupant extends Model
{
    use HasFactory;
    use Helpers;
  
   
    protected $fillable = [
        'id','nekoId', 'realestate_id', 'unvid', 'budguid','nutzeinheitNo', 'dateFrom', 'dateTo', 'anrede', 'title', 'nachname', 'vorname', 'address',
        'street', 'postcode', 'houseNr', 'city', 'vat', 'uaw', 'qmkc', 'qmww', 'pe', 'bemerkung', 'vorauszahlung', 'lokalart', 'customEinheitNo', 'lage', 'email',
        'telephone_number', 'eigentumer', 'date_from_editing', 'qmkc_editing', 'vorauszahlung_editing', 'vorauszahlung_editing', 'personen_zahl', 'OptimisticLockField'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function realestate()
    {
        return $this->belongsTo(Realestate::class);
    }

    public function counterMeters()
    {
        return $this->hasMany(VerbrauchsinfoCounterMeter::class);
    }

    public function userVerbrauchsinfoAccessControls()
    {
        return $this->hasMany(UserVerbrauchsinfoAccessControl::class);
    }

    public static function validateImportData($data)
    {
        return  Validator::make($data, [
            'nekoId' => 'required|string|max:40',
            'budguid' => 'required|string|max:40',
            'unvid' => 'required|string|max:255',
            'nutzeinheitNo' => 'required|integer',
            'dateFrom' => 'required|date',
            'nachname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'street' => 'sometimes|string',
            'city' => 'sometimes|string',
            'postcode' => 'sometimes|string',
            'houseNr' => 'sometimes',
            'vat' => 'required|boolean',
            'uaw' => 'required|boolean',
            'qmkc' => 'required|numeric',
            'qmww' => 'required|numeric',
            'pe' => 'required|numeric',
            'vorauszahlung' => 'required|numeric',
        ]);
    }

    protected $casts = ['dateFrom' => 'date:d.m.Y',
                    'dateTo' => 'date:d.m.Y',
                    'qmkc' => 'decimal:2',
                    'qmww' => 'decimal:2',
                    'vorauszahlung_editing' => 'decimal:2' ];

    protected $appends = ['date_from_editing',
                        'date_to_editing',
                        'vorauszahlung_editing',
                        'personen_zahl',
                        'display_einheit',
                        'display_eigentumer_name',
                        'can_delete',
                        'qmkc_editing'];


   protected function getDisplayConditionalWithAdressAttribute(){
        

   }

    
    protected function setPersonenZahlAttribute($value){
        $q = $this->personcounts
        ->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id);

        $personcount = Personcount::updateOrCreate(
            ['occupant_id' => $this->id,'abrechnungssetting_id' => $this->realestate->abrechnungssetting_id],
            [
            'countvalue' => $this->castStringToDouble($value), 
        ]);
    }

   protected function getPersonenZahlAttribute(){
        $q = $this->personcounts
        ->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id);
        if ($q->count() == 0 ) {
            return '0,00';
        }else{
            return number_format($q->first()->countvalue, 2, ',', '.');
        }
    }

    protected function getDateFromEditingAttribute()
    {
        return Carbon::parse($this->dateFrom)->format('d.m.Y');
    }

    protected function setDateFromEditingAttribute($value)
    {
        try {
            $this->dateFrom = Carbon::parse($value);
        } catch (\Carbon\Exceptions\InvalidFormatException $e) {

        }
    }

    protected function getDateToEditingAttribute()
    {
        if($this->dateTo){
            return Carbon::parse($this->dateTo)->format('d.m.Y');
        }
        return '';
    }

    protected function setDateToEditingAttribute($value)
    {
        Debugbar::info('Occupant-setDateToEditingAttribute:'. $value);
        if($value)
        {
            $this->dateTo = Carbon::parse($value);
        }
    }


    protected function setQmkcEditingAttribute($value){
         $this->qmkc = $this->castStringToDouble($value);
    }

    protected function getQmkcEditingAttribute(){
        return number_format($this->qmkc, 2, ',', '.');
    }

    protected function setVorauszahlungEditingAttribute($value){
            $field = null;
            $q = $this->preapaids
            ->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('prepaidtype','=', $this->realestate->prepaidtype);
            
            if($this->realestate->eingabeCostNetto == 1){
                $field ='netAmount';
            }else{
                $field = 'grosAmount';
            }

            $prepaid = Prepaid::updateOrCreate(
                ['occupant_id' => $this->id, 'prepaidtype' => $this->realestate->prepaidtype,'abrechnungssetting_id' => $this->realestate->abrechnungssetting_id],
                [
                $field => $this->castStringToDouble($value), 
            ]);
        }

    protected function getVorauszahlungEditingAttribute(){
        $q = $this->preapaids
        ->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
        ->where('prepaidtype','=', $this->realestate->prepaidtype);

        if ($q->count() == 0 ) {
            return '0,00';
        }else{
            if($this->realestate->eingabeCostNetto == 1){
                return number_format($q->first()->netAmount, 2, ',', '.');
            }else{
                return number_format($q->first()->grosAmount, 2, ',', '.');
            }
        }
    }

    protected function getZeitraumAttribute(){
        if ($this->dateTo){
            return Carbon::parse($this->dateFrom)->format('d.m.Y') . ' - '. Carbon::parse($this->dateTo)->format('d.m.Y');
        }else{
            return Carbon::parse($this->dateFrom)->format('d.m.Y') . ' - __.__.____';
        }
    }

    protected function getZeitraumTextAttribute(){

        if ($this->dateTo){
            return 'vom '. Carbon::parse($this->dateFrom)->format('d.m.Y') . ' bis '. Carbon::parse($this->dateTo)->format('d.m.Y');
        }else{
            return 'seit '. Carbon::parse($this->dateFrom)->format('d.m.Y') ;
        }

    }

    protected function getNutzerKennnummerAttribute()
    {
        return substr($this->unvid,12,3). '-'. substr($this->unvid,15,3);
    }

    protected function getNutzerMitLageAttribute(){
        if ($this->lage){
            return $this->getNutzerKennnummerAttribute() . " ". $this->lage ;
        }
        else {
            return $this->getNutzerKennnummerAttribute() ;
        }
    }

    protected function getCustomEinheitNoMitLageAttribute(){
        if ($this->lage){

            return $this->DisplayEinheit.' '.$this->lage;
        }
        else {
            return $this->DisplayEinheit ;
        }
    }

    protected function getDisplayEinheitAttribute(){
        if ($this->customEinheitNo){
            return $this->customEinheitNo;
        }
        else {
            return $this->NutzerKennnummer ;
        }
    }
   
    protected function getDisplayEigentumerNameAttribute(){
        if ($this->eigentumer){
            return $this->eigentumer;
        }
        else {
            return $this->nachname ;
        }
    }
    protected function getCanDeleteAttribute(){
        $ret_val = false;
        if ($this->nekoId == 'new'){ $ret_val = true;} 
        return $ret_val;
    }

    public function visibleVerbrauchsinfos()
    {
        $q = $this->userVerbrauchsinfoAccessControls
            ->where('user_id', '=', auth()->user()->id)
            ->map(function (UserVerbrauchsinfoAccessControl $userControl) {
                return $userControl->jahr_monat ;
            });


        $result = $this->verbrauchsinfos
            ->whereIn('jahr_monat', $q)->toquery();

        return $result->get();
    }

    public function verbrauchsinfos()
    {
        return $this->hasMany(Verbrauchsinfo::class);
    }

    public function verbrauchsinfoUserEmails()
    {
        return $this->hasMany(VerbrauchsinfoUserEmail::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function preapaids()
    {
        return $this->hasMany(Prepaid::class);
    }

    public function personcounts()
    {
        return $this->hasMany(Personcount::class);
    }

    public function livingareas()
    {
        return $this->hasMany(Livingarea::class);
    }

}
