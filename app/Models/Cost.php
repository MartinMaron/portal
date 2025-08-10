<?php

namespace App\Models;

use App\Events\CostUpdated;
use App\Http\Traits\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Usernotnull\Toast\Concerns\WireToast;

class Cost extends Model
{
    use HasFactory;
    use Helpers;
    use WireToast;

    protected $fillable = [
        'realestate',
        'realestate_id', 'nekoId', 'caption', 'description', 'costtype_id', 'costtype',
        'fueltype_id', 'startValue', 'endValue',
        'startValueAmountNet', 'startValueAmountGros', 'startValueAmountVat',
        'haushaltsnah', 'co2Tax', 'costkey_id', 'consumption', 'costkey',
        'noticeForUser', 'noticeForNeko',
        'prevyearPeriod', 'prevyearQuantity', 'prevyearAmountnet', 'prevyearAmountgros',
        'OptimisticLockField', 'periodFrom', 'periodTo'
    ];


    #region scopes
    public function scopeIsHeizkosten($query)
    {
        $ret_val = $query
            ->where(function ($query) {
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
            ->where(function ($query) {
                $query->where('costtype_id', 'BRK');
            });

        return $ret_val;
    }

    public function scopeIsBetriebskosten($query)
    {
        $ret_val = $query
            ->where(function ($query) {
                $query->where('costtype_id', 'BEK')
                    ->orWhere('costtype_id', 'BEE');
            });

        return $ret_val;
    }
    #endregion
    
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
        'start_value_editing' => 'decimal:3',
        'end_value_editing' => 'decimal:1',
        'startValueAmountGros' => 'decimal:2',
        'startValueAmountNet' => 'decimal:2',        
        'haushaltsnah' => 'boolean'];

    /* Laravel 11 Attribute casting refactored accessors/mutators */
    protected function needCostkey(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->costtype != null && ! in_array($this->costtype->id, ['BRK','HNK','ZUK','ZKW'], true)
        );
    }

    protected function canCo2(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->fueltype != null && in_array($this->fueltype_id, ['EC4','GS4','OL9'], true)
        );
    }

    protected function prevyearQuantityView(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->prevyearQuantity ? number_format($this->prevyearQuantity, 2, ',', '.') : null
        );
    }

    protected function prevyearAmountnetView(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->prevyearAmountnet ? number_format($this->prevyearAmountnet, 2, ',', '.') : null
        );
    }

    protected function prevyearAmountgrosView(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->prevyearAmountgros ? number_format($this->prevyearAmountgros, 2, ',', '.') : null
        );
    }

    protected function netto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? number_format($this->costAmounts
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->sum('netAmount'), 2, ',', '.') : null
        );
    }

    protected function brutto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? number_format($this->costAmounts
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->sum('grosAmount'), 2, ',', '.') : null
        );
    }

    protected function haushaltsnahSum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? number_format($this->costAmounts
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->sum('grosAmount_HH'), 2, ',', '.') : null
        );
    }

    protected function consumptionsum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? number_format($this->costAmounts
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->sum('consumption'), 1, ',', '.') : null
        );
    }

    protected function coconsumptionsum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? number_format($this->costAmounts
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->sum('co2TaxValue'), 1, ',', '.') : null
        );
    }

    protected function cobruttosum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? number_format($this->costAmounts
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->sum('co2TaxAmount_gros'), 1, ',', '.') : null
        );
    }

    protected function conettosum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? number_format($this->costAmounts
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->sum('co2TaxAmount_net'), 1, ',', '.') : null
        );
    }

    protected function costTypeSort(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->costtype ? $this->costtype->sort : 10000
        );
    }

    protected function gros(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->realestate ? $this->costAmounts
                ->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                ->where('startvalue', false)
                ->where('endvalue', false)
                ->sum('grosAmount') : 0
        );
    }

    protected function startValueEditing(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('startvalue', true)->get();
                    if ($q->count() > 0) {
                        return $q->first()->consumption_editing;
                    } else {
                        return '0,00';
                    }
                }
                return '0,00';
            },
            set: function ($value) {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('startvalue', true)->get();
                    if ($q->count() > 0) {
                        $rec = $q->first();
                        $rec->consumption_editing = $value;
                        $rec->save();
                    }
                }
                return null;
            }
        );
    }

    protected function startValueAmountNetEditing(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('startvalue', true)->get();
                    if ($q->count() > 0) {
                        return $q->first()->netto;
                    } else {
                        return '0,0';
                    }
                }
                return '0,0';
            },set: function ($value) {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('startvalue', true)->get();
                    if ($q->count() > 0) {
                        $rec = $q->first();
                        $rec->netto = $value;
                        $rec->save();
                    }
                }
                return null;
            }
        );
    }

    protected function startValueAmountGrosEditing(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('startvalue', true)->get();
                    if ($q->count() > 0) {
                        return $q->first()->brutto;
                    } else {
                        return '0,00';
                    }
                }
                return '0,00';
            },
            set: function ($value) {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('startvalue', true)->get();
                    if ($q->count() > 0) {
                        $rec = $q->first();
                        $rec->brutto = $value;
                        $rec->save();
                    }
                }
                return null;
            }
        );
    }

    protected function endValueEditing(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('endvalue', true)->get();
                    if ($q->count() > 0) {
                        return $q->first()->consumption_editing;
                    }
                    return '0,0';
                }
                return '0,0';
            },
            set: function ($value) {
                if ($this->costAmounts() && $this->costtype_id == 'BRK' && $this->fueltype && $this->fueltype->hasTank) {
                    $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)
                        ->where('endvalue', true)->get();
                    if ($q->count() > 0) {
                        $rec = $q->first();
                        $rec->consumption_editing = $value;
                        $rec->save();
                    }
                }
                return null;
            }
        );
    }

    protected function editable(): Attribute
    {
        return Attribute::make(
            get: function () {
                $q = $this->costAmounts()->where('abrechnungssetting_id', $this->realestate->abrechnungssetting_id)->get();
                if ($this->costtype != 'BRK' && $q->count() > 0 && $q->count() == $q->where('nekoId','!=',0)->count()) {
                    return false;
                }
                return true;
            }
        );
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
        return $this->belongsTo(CostKey::class);
    }

    public function costtype()
    {
        return $this->belongsTo(CostType::class);
    }

    public function fueltype()
    {
        return $this->belongsTo(FuelType::class);
    }

    protected $dispatchesEvents = [
        'updated' => CostUpdated::class,
    ];
}
