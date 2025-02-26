<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Traits\Helpers;
use App\Events\CostUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cost extends Model
{
    use HasFactory;
    use WireToast;
    use Helpers;

    protected $fillable = [
        'realestate',
        'realestate_id', 'nekoId', 'caption', 'description', 'costtype_id', 'costtype',
        'fueltype_id', 'startValue', 'endValue',
        'startValueAmountNet', 'startValueAmountGros', 'startValueAmountVat', 
        'haushaltsnah', 'co2Tax', 'costkey_id', 'consumption', 'costkey',
        'noticeForUser', 'noticeForNeko', 
        'prevyearPeriod', 'prevyearQuantity', 'prevyearAmountnet', 'prevyearAmountgros',
        'OptimisticLockField'
    ];

    public function scopeIsHeizkosten($query)
    {
        $ret_val = $query
        ->where(function($query)
        {
            $query->where('costtype_id', 'HNK')
            ->orWhere('costtype_id', 'KWK')
            ->orWhere('costtype_id', 'KWA')
            ->orWhere('costtype_id', 'ZKW')
            ->orWhere('costtype_id', 'DIR')
            ->orWhere('costtype_id', 'BEH')
            ->orWhere('costtype_id', 'ZWA')
            ->orWhere('costtype_id', 'ZUK');
        });
        return $ret_val;
    }
    public function scopeIsBrennstoffkosten($query)
    {
        $ret_val = $query
        ->where(function($query)
        {
            $query->where('costtype_id', 'BRK');
        });
        return $ret_val;
    }

    public function scopeIsBetriebskosten($query)
    {
        $ret_val = $query
        ->where(function($query)
        {
            $query->where('costtype_id', 'BEK')
            ->orWhere('costtype_id', 'BEE');
        });
        return $ret_val;
    }


    protected $appends = [
                            'cost_type_sort',
                            'consumptionsum',
                            'coconsumptionsum',
                            'cobruttosum',
                            'conettosum',
                            'brutto',
                            'netto',
                            'gros',
                            'start_value_editing',
                            'end_value_editing',
                            'start_value_amount_gros_editing',
                            'start_value_amount_net_editing',
                            'prevyear_quantity_view', 
                            'prevyear_amountnet_view',
                            'prevyear_amountgros_view',
                            'need_costkey',
                            'can_co2',
                            'haushaltsnah_sum',
                        ];

    protected $casts = ['consumptionsum' => 'decimal:1',
                        'netto' => 'decimal:2',
                        'brutto' => 'decimal:2',
                        'start_value_editing' => 'decimal:1',
                        'end_value_editing' => 'decimal:1',
                        'startValueAmountGros' => 'decimal:2',
                        'startValueAmountNet' => 'decimal:2' ];

    
    
    
    public function getNeedCostkeyAttribute(){
        return  $this->costtype != null &&
                !($this->costtype->id == 'BRK' ||
                $this->costtype->id == 'HNK' ||
                $this->costtype->id == 'ZUK' ||
                $this->costtype->id == 'ZKW');
    }

    public function getCanCo2Attribute(){
        return $this->fueltype != null &&
                ($this->fueltype_id == 'EC4' ||
                $this->fueltype_id == 'GS4' ||
                $this->fueltype_id == 'OL9');
    }

    public function getPrevyearQuantityViewAttribute(){
        if ($this->prevyearQuantity) {
            return number_format($this->prevyearQuantity, 2, ',', '.');
        } else {
            return null;        
        }
    }
    public function getPrevyearAmountnetViewAttribute(){
        if ($this->prevyearAmountnet) {
            return number_format($this->prevyearAmountnet, 2, ',', '.');
        } else {
            return null;        
        }
    }
    public function getPrevyearAmountgrosViewAttribute(){
        if ($this->prevyearAmountgros) {
            return number_format($this->prevyearAmountgros, 2, ',', '.');
        } else {
            return null;        
        }
    }

    public function getNettoAttribute(){
        if ($this->realestate) {
            return number_format($this->costAmounts
            ->where('startvalue','=', false)
            ->where('endvalue','=', false)
            ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
            ->sum('netAmount'), 2, ',', '.');
        } else {
        return null;        
        }
    }
    public function getBruttoAttribute(){
        if ($this->realestate) {
            return number_format($this->costAmounts
                ->where('startvalue','=', false)
                ->where('endvalue','=', false)
                ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
                ->sum('grosAmount'), 2, ',', '.');
        } else {
        return null;        
        }
    }

    public function getHaushaltsnahSumAttribute(){
        if ($this->realestate) {
            return number_format($this->costAmounts
                ->where('startvalue','=', false)
                ->where('endvalue','=', false)
                ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
                ->sum('grosAmount_HH'), 2, ',', '.');
        } else {
        return null;        
        }
    }
    public function getConsumptionsumAttribute(){
        if ($this->realestate) {
            return number_format($this->costAmounts
            ->where('startvalue','=', false)
            ->where('endvalue','=', false)
            ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
            ->sum('consumption'), 1, ',', '.');
        } else {
        return null;        
        }
    }
    public function getCoconsumptionsumAttribute(){
        if ($this->realestate) {
            return number_format($this->costAmounts
                ->where('startvalue','=', false)
                ->where('endvalue','=', false)
                ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
                ->sum('co2TaxValue'), 1, ',', '.');
        } else {
        return null;        
        }
    }
    public function getCobruttosumAttribute(){
        if ($this->realestate) {
            return number_format($this->costAmounts
                ->where('startvalue','=', false)
                ->where('endvalue','=', false)
                ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
                ->sum('co2TaxAmount_gros'), 1, ',', '.');
        } else {
        return null;        
        }
    }

    public function getConettosumAttribute(){
        
        if ($this->realestate) {
            return number_format($this->costAmounts
                    ->where('startvalue','=', false)
                    ->where('endvalue','=', false)
                    ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
                    ->sum('co2TaxAmount_net'), 1, ',', '.');
        } else {
        return null;        
        }
    }


    public function getCostTypeSortAttribute()
    {
        if ($this->costtype != null) {
            return $this->costtype->sort;
        }
        return 10000;
    }
    public function getGrosAttribute(){
            if ($this->realestate) {
            return $this->costAmounts
                    ->where('abrechnungssetting_id','=',$this->realestate->abrechnungssetting_id)
                    ->where('startvalue','=', false)
                    ->where('endvalue','=', false)
                    ->sum('grosAmount');
        } else {
        return 0;        
        }
    }

    public function setStartValueEditingAttribute($value){
        if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
            $q = $this->costAmounts()->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('startvalue','=', true)->get();
            if ($q->count() > 0) {
                $q->first()->consumption_editing = $value;
                $q->first()->save();
            } else {
                return 'k.A.';
            }
        }else
        {
            return 'k.A.';
        }
    }

    public function getStartValueEditingAttribute(){
        if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
            $q = $this->costAmounts()->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('startvalue','=', true)->get();
            if ($q->count() > 0) {
                return $q->first()->consumption_editing;
            } else {
                return 'k.A.';
            }
        }else
        {
            return 'k.A.';
        }
    }

    public function setStartValueAmountNetEditingAttribute($value){
        if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
            $q = $this->costAmounts()->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('startvalue','=', true)->get();
            if ($q->count() > 0) {
                $q->first()->netto = $value;
                $q->first()->save();
            } else {
                return 'k.A.';
            }
        }else
        {
            return 'k.A.';
        }
    }

    public function getStartValueAmountNetEditingAttribute(){
        if ($this->startValueAmountNet <> 0){
            return number_format($this->startValueAmountNet, 1, ',', '.');
        }else{
            return '';
        } 
    }

    public function setStartValueAmountGrosEditingAttribute($value){
        if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
            $q = $this->costAmounts()->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('startvalue','=', true)->get();
            if ($q->count() > 0) {
                $q->first()->brutto = $value;
                $q->first()->save();
            } else {
                return 'k.A.';
            }
        }else
        {
            return 'k.A.';
        }
    }

    public function getStartValueAmountGrosEditingAttribute(){
        if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
            $q = $this->costAmounts()->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('startvalue','=', true)->get();
            if ($q->count() > 0) {
                return $q->first()->brutto;
            } else {
                return 'k.A.';
            }
        }else
        {
            return 'k.A.';
        }
    }

    public function setEndValueEditingAttribute($value){
        if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
            $q = $this->costAmounts()->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('endvalue','=', true)->get();
            if ($q->count() > 0) {
                $q->first()->consumption_editing = $value;
                $q->first()->save();
            }
        }
    }

    public function getEndValueEditingAttribute(){
        if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
            $q = $this->costAmounts()->where('abrechnungssetting_id','=', $this->realestate->abrechnungssetting_id)
            ->where('endvalue','=', true)->get();
            if ($q->count() > 0) {
                return $q->first()->consumption_editing;
            } else {
                return '0,0';
            }
        }else
        {
            return '0,0';
        }
    }

    public function getEditableAttribute()
    {
        if ($this->costtype != 'BRK' && $this->costAmounts->count() > 0 && 
            $this->costAmounts->count() == $this->costAmounts()->where('nekoId','!=',0)->get()->count()) {
            return false;
        }
        return true;
    }

    public function realestate()
    {
        return $this->belongsTo(Realestate::class);
    }

    public function costAmounts()
    {
        return $this->hasMany(CostAmount::class);
    }

    public function costkey()
    {
        return $this->belongsTo(Costkey::class);
    }

    public function costtype()
    {
        return $this->belongsTo(Costtype::class);
    }

    public function fueltype()
    {
        return $this->belongsTo(Fueltype::class);
    }

    protected $dispatchesEvents = [
        'updated' => CostUpdated::class,
    ];
}
