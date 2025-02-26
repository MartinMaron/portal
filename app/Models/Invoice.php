<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'createDate', 'caption', 'description', 'fileName', 'dateFrom', 'dateTo', 'nekoId', 'realestate_id',
        'vertragsart','bezahlt','bezahltAm','zahlungsAuftragDatum','zahlungsauftragIBAN','netto','vat','brutto'
    ];

    public function realestate()
    {
        return $this->belongsTo(Realestate::class);
    }


    public static function validateImportData($data)
    {
        return  Validator::make($data, [
            'nekoId' => 'required|integer',
            'createDate' => 'required|date',
            'caption' => 'required|string|max:255',
            'description' => 'sometimes',
            'fileName' => 'sometimes',
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date',
            'vertragsart' => 'required|string|max:255',
            'bezahlt' => 'required|boolean',
            'bezahltAm' => 'sometimes',
            'zahlungsAuftragDatum' => 'sometimes',
            'zahlungsauftragIBAN' => 'sometimes',
            'netto' => 'required|numeric',
            'vat' => 'required|numeric',
            'brutto' => 'required|numeric',
        ]);
    }

    protected $casts = ['dateFrom' => 'date:d.m.Y',
                        'dateTo' => 'date:d.m.Y',
                        'createDate' => 'date:d.m.Y',
                        'brutto' => 'decimal:2'
                    ];


    protected $appends = ['date_from_editing',
                          'date_to_editing',
                          'create_date_editing',
                          'bezahlt_am_editing',
                          'brutto_betrag'
                    ];

    public function getDateFromEditingAttribute()
    {
        return Carbon::parse($this->dateFrom)->format('d.m.Y');
    }

    public function setDateFromEditingAttribute($value)
    {
        $this->dateFrom = Carbon::parse($value);
    }

    public function getDateToEditingAttribute()
    {
        if($this->dateTo){
            return Carbon::parse($this->dateTo)->format('d.m.Y');
        }
        return '';
    }

    public function getBezahltAmEditingAttribute()
    {
        if($this->bezahltAm == '0001-01-01'){
            return '';    
        }
        if($this->bezahltAm){
            return Carbon::parse($this->bezahltAm)->format('d.m.Y');
        }
        return '';
    }

    public function setDateToEditingAttribute($value)
    {
        $this->dateTo = Carbon::parse($value);
    }

    public function getCreateDateEditingAttribute()
    {
        if($this->createDate){
            return Carbon::parse($this->createDate)->format('d.m.Y');
        }
        return '';
    }

    public function setCreateDateEditingAttribute($value)
    {
        $this->dateTo = Carbon::parse($value);
    }

    protected function getBruttoBetragAttribute(){
        return number_format($this->brutto, 2, ',', '.');
    }

}
