<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Traits\Helpers;
use App\Events\CostAmountAdded;
use App\Events\CostAmountDeleted;
use App\Events\CostAmountUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CostAmount extends Model
{
    use HasFactory;
    use Helpers;
    use WireToast; 
   
    protected $fillable = [
        'nekoId', 'cost_id', 'bemerkung', 'description', 'created_at',
        'netAmount', 'grosAmount', 'dateCostAmount', 'consumption', 'netto', 'brutto', 
        'grosAmount_HH', 'co2TaxValue','co2TaxAmount_gros','co2TaxAmount_net','cobrutto',
        'abrechnungssetting_id'
    ];

    protected $casts = [
        'datum' => 'date:d.m.Y',
        'grosAmount' => 'decimal:2',
        'consumption' => 'decimal:3',
        'consumption_editing' => 'decimal:1',
        'brutto' => 'decimal:2',
        'netto' => 'decimal:2',
        'cobrutto' => 'decimal:2',
        'conetto' => 'decimal:2',
        'coconsupmtion' => 'decimal:1',
        'grosAmount_HH' => 'decimal:2',
        'netAmount' => 'decimal:2' ];

    protected $appends = [
        'consumption_editing',
        'brutto',
        'netto',
        'cobrutto',
        'conetto',
        'coconsupmtion',
        'datum',
        'haushaltsnah',
    ];


    public function cost()
    {
        return $this->belongsTo(Cost::class);
    }

    public function setConsumptionEditingAttribute($value){
        $this->consumption = $this->castStringToDouble($value);
    }

    public function getConsumptionEditingAttribute(){
        if($this->consumption){
            return number_format($this->consumption, 1, ',', '.');            
        }
        return null;
    }
    public function setBruttoAttribute($value){
        $this->grosAmount = $this->castStringToDouble($value);
    }

    public function getBruttoAttribute(){
        if ($this->grosAmount) {
            return number_format($this->grosAmount, 2, ',', '.');
        } else {
            return "0,00";
        }
    }

    public function setNettoAttribute($value){
        $this->netAmount = $this->castStringToDouble($value);
    }

    public function getNettoAttribute(){
        if ($this->netAmount) {
            return number_format($this->netAmount, 2, ',', '.');
        } else {
            return "0,00";
        }
    }

    public function setHaushaltsnahAttribute($value){
        $this->grosAmount_HH = $this->castStringToDouble($value);
    }

    public function getHaushaltsnahAttribute(){
        if ($this->grosAmount_HH) {
            return number_format($this->grosAmount_HH, 2, ',', '.');
        } else {
            return 0;
        }
    }

    public function getDatumAttribute()
    {
        if($this->dateCostAmount){
            return Carbon::parse($this->dateCostAmount)->format('d.m.Y');
        }
    }
    public function setDatumAttribute($value)
    {
        Debugbar::info('CostAmount-setDatumAttribute:'. $value);
        try {           
            if ($value) {
                $this->dateCostAmount = Carbon::parse($value);
                $value = str_replace('.','',$value);
                $dt = Carbon::createFromFormat('dmY', $value);
                $this->dateCostAmount = Carbon::parse($dt);
            }else
            {
                $this->dateCostAmount = null;
            }   
         } catch (Exception $e) {
         }
    }

    public function setCobruttoAttribute($value){
        $this->co2TaxAmount_gros = $this->castStringToDouble($value);
    }

    public function getCobruttoAttribute(){
        return number_format($this->co2TaxAmount_gros, 2, ',', '.');
    }
    
    public function setCoconsupmtionAttribute($value){
        $this->co2TaxValue = $this->castStringToDouble($value);
    }

    public function getCoconsupmtionAttribute(){
        if ($this->co2TaxValue) {
            return number_format($this->co2TaxValue, 0, ',', '.');
        } else {
            return 0;
        }
        
    }

    public function setConettoAttribute($value){
        $this->co2TaxAmount_net = $this->castStringToDouble($value);
    }

    public function getConettoAttribute(){
        return number_format($this->co2TaxAmount_net, 2, ',', '.');
    }

    protected $dispatchesEvents = [
        'created' => CostAmountAdded::class,
        'updated' => CostAmountUpdated::class,
        'deleted' => CostAmountDeleted::class,
    ];

}
