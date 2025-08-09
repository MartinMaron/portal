<?php

namespace App\Models;

use App\Events\CostAmountAdded;
use App\Events\CostAmountDeleted;
use App\Events\CostAmountUpdated;
use App\Http\Traits\Helpers;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Usernotnull\Toast\Concerns\WireToast;

class CostAmount extends Model
{
    use HasFactory;
    use Helpers;
    use WireToast;

    protected $fillable = [
        'nekoId', 'cost_id', 'bemerkung', 'description', 'created_at',
        'netAmount', 'grosAmount', 'dateCostAmount', 'consumption', 'netto', 'brutto',
        'grosAmount_HH', 'co2TaxValue', 'co2TaxAmount_gros', 'co2TaxAmount_net', 'cobrutto',
        'abrechnungssetting_id',
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
        'netAmount' => 'decimal:2'];

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

    public function consumptionEditing(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->consumption ? number_format($this->consumption, 1, ',', '.') : '0,0',
            set: fn ($value) => ['consumption' => $this->castStringToDouble($value)]
        );
    }

    public function brutto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->grosAmount ? number_format($this->grosAmount, 2, ',', '.') : '0,00',
            set: fn ($value) => ['grosAmount' => $this->castStringToDouble($value)]
        );
    }

    public function netto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->netAmount ? number_format($this->netAmount, 2, ',', '.') : '0,00',
            set: fn ($value) => ['netAmount' => $this->castStringToDouble($value)]
        );
    }

    public function haushaltsnah(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->grosAmount_HH ? number_format($this->grosAmount_HH, 2, ',', '.') : '0,00',
            set: fn ($value) => ['grosAmount_HH' => $this->castStringToDouble($value)]
        );
    }

    public function datum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->dateCostAmount ? Carbon::parse($this->dateCostAmount)->format('d.m.Y') : null,
            set: function ($value) {
                if ($value) {
                    try {
                        $dt = str_replace('.', '', $value);
                        $dt = Carbon::createFromFormat('dmY', $dt);
                        return ['dateCostAmount' => Carbon::parse($dt)];
                    } catch (\Exception $e) {
                        return ['dateCostAmount' => null];
                    }
                }
                return ['dateCostAmount' => null];
            }
        );
    }

    public function cobrutto(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->co2TaxAmount_gros, 2, ',', '.'),
            set: fn ($value) => ['co2TaxAmount_gros' => $this->castStringToDouble($value)]
        );
    }

    public function coconsupmtion(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->co2TaxValue ? number_format($this->co2TaxValue, 0, ',', '.') : 0,
            set: fn ($value) => ['co2TaxValue' => $this->castStringToDouble($value)]
        );
    }

    public function conetto(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->co2TaxAmount_net ?? 0, 2, ',', '.'),
            set: fn ($value) => ['co2TaxAmount_net' => $this->castStringToDouble($value)]
        );
    }

    protected $dispatchesEvents = [
        'created' => CostAmountAdded::class,
        'updated' => CostAmountUpdated::class,
        'deleted' => CostAmountDeleted::class,
    ];
}
