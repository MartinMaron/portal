<?php

namespace App\Http\Traits\Helper;
use Carbon\Carbon;
use App\Models\Cost;
use App\Models\CostAmount;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;

trait CostHelper
{

    public function makeBlankObjectBrennstoffkosten(Cost $cost)
    {
        return Cost::make([
            'nekoId' => 0,
            'co2Tax' => $cost->co2Tax,
            'realestate_id' => $cost->realestate->id,
            'costtype_id' => $cost->costtype_id,
            'consumption' => true,
            'haushaltsnah' => false,
            'noticeForNeko' => '',
            'periodFrom' => $cost->realestate->abrechnungssetting->periodFrom ?? null,
            'periodTo' => Carbon::createFromDate('2099-12-31'),
            'costkey_id' => $cost->costkey_id
        ]);
    }

    public function makeBlankObjectHeizkosten(Cost $cost)
    {
        return Cost::make([
            'nekoId' => 0,
            'co2Tax' => $cost->co2Tax,
            'realestate_id' => $cost->realestate->id,
            'costtype_id' => $cost->costtype_id,
            'consumption' => false,
            'haushaltsnah' => false,
            'noticeForNeko' => '',
            'periodFrom' => $cost->realestate->abrechnungssetting->periodFrom ?? null,
            'periodTo' => Carbon::createFromDate('2099-12-31'),
            'costkey_id' => $cost->costkey_id
        ]);
    }

    public function makeBlankObjectBetriebskosten(Realestate $realestate)
    {
        return Cost::make([
            'nekoId' => 0,
            'realestate_id' => $realestate->id,
            'costtype_id' => 'BEK',
            'co2Tax' => 0,
            'consumption' => false,
            'haushaltsnah' => false,
            'costkey_id' => $realestate->costsKeys->where('viewText', '=', 'Wohnfläche')->first()->id ?? null,
            'noticeForNeko' => '',
            'periodFrom' => $realestate->abrechnungssetting->periodFrom ?? null,
            'periodTo' => Carbon::createFromDate('2099-12-31')
        ]);
    }

    public function hasCo2Tax(Cost $cost)
    {
        return $cost->fueltype != null &&
                ($cost->fueltype_id == 'EC4' ||
                $cost->fueltype_id == 'GS4' ||
                $cost->fueltype_id == 'OL9');
    }

    public function fill_changed_data_from($object, Cost $cost)
    {
        if ($object['costtype_id'] == 'BEK' 
            || $object['costtype_id'] == 'BEE') {
                $cost->realestate_id = $object['realestate_id'];
                $cost->costtype_id = $object['costtype_id'];
                $cost->consumption = $object['consumption'];
                $cost->nekoId = $object['nekoId'];
                $cost->caption = $object['caption'];
                $cost->haushaltsnah = $object['haushaltsnah'];
                $cost->co2Tax = $object['co2Tax'];
                $cost->costkey_id = $object['costkey_id'];
                $cost->noticeForNeko = $object['noticeForNeko'];
                $cost->periodFrom = $object['periodFrom'];
                $cost->periodTo = $object['periodTo'];
                $cost->OptimisticLockField = $cost->OptimisticLockField + 1;
        } elseif ($object['costtype_id'] == 'BEH' 
            || $object['costtype_id'] == 'DIR'
            || $object['costtype_id'] == 'HNK' 
            || $object['costtype_id'] == 'KWK' 
            || $object['costtype_id'] == 'ZKW' 
            || $object['costtype_id'] == 'ZWA' 
            || $object['costtype_id'] == 'ZUK' 
            || $object['costtype_id'] == 'KWA')
            {
                $cost->realestate_id = $object['realestate_id'];
                $cost->costtype_id = $object['costtype_id'];
                $cost->consumption = $object['consumption'];
                $cost->nekoId = $object['nekoId'];
                $cost->caption = $object['caption'];
                $cost->haushaltsnah = $object['haushaltsnah'];
                $cost->co2Tax = $object['co2Tax'];
                $cost->costkey_id = $object['costkey_id'];
                $cost->noticeForNeko = $object['noticeForNeko'];
                $cost->periodFrom = $object['periodFrom'];
                $cost->periodTo = $object['periodTo'];
                $cost->OptimisticLockField = $cost->OptimisticLockField + 1;
        } else {
            //Brennstoffkosten
            $cost->realestate_id = $object['realestate_id'];
            $cost->costtype_id = $object['costtype_id'];
            $cost->fueltype_id = $object['fueltype_id'];
            $cost->consumption = $object['consumption'];
            $cost->nekoId = $object['nekoId'];
            $cost->caption = $object['caption'];
            $cost->haushaltsnah = $object['haushaltsnah'];
            $cost->co2Tax = $object['co2Tax'];
            $cost->costkey_id = $object['costkey_id'];
            $cost->noticeForNeko = $object['noticeForNeko'];
            $cost->periodFrom = $object['periodFrom'];
            $cost->periodTo = $object['periodTo'];
            $cost->OptimisticLockField = $cost->OptimisticLockField + 1;
        }
        return $cost;
    }

    public function getDefaultCostAmount(Cost $cost)
    {
       return CostAmount::firstOrNew([
           'cost_id' => $cost->id,
           'abrechnungssetting_id' => $cost->realestate->abrechnungssetting_id,
           'startvalue' => 0,
           'endvalue' => 0,
       ]);
    }

    public function getNewCostAmount(Cost $cost)
    {
       return CostAmount::make([
           'cost_id' => $cost->id,
           'abrechnungssetting_id' => $cost->realestate->abrechnungssetting_id,
           'startvalue' => 0,
           'endvalue' => 0,
       ]);
    }

    public function hasConsumptionByType($costtypeId, Realestate $realestate)
    {
        $ret = Cost::where('realestate_id', '=', $realestate->id)
            ->where(function (Builder $query) use ($costtypeId) {
                if($costtypeId == 'BEK' || $costtypeId == 'BEH') 
                    {
                    $query->IsBetriebskosten();
                }elseif($costtypeId == 'BRK') {
                    $query->IsBrennstoffkosten();
                }else {
                    $query->IsHeizkosten();
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $this->realestate->abrechnungssetting->periodTo);
                }
            })
            ->where('costtype_id', '=', $costtypeId)
            ->where('consumption', '=', 1)
            ->count();
        return (bool) ($ret > 0);
    }

    public function hasHaushaltsnahByType($costtypeId, Realestate $realestate)
    {
        $ret = Cost::where('realestate_id', '=', $realestate->id)
            ->where(function (Builder $query) use ($costtypeId) {
                if($costtypeId == 'BEK' || $costtypeId == 'BEH') 
                    {
                    $query->IsBetriebskosten();
                }elseif($costtypeId == 'BRK') {
                    $query->IsBrennstoffkosten();
                }else {
                    $query->IsHeizkosten();
                }
            })->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $this->realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) {
                if ($this->realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $this->realestate->abrechnungssetting->periodTo);
                }
            })
            ->where('costtype_id', '=', $costtypeId)
            ->where('haushaltsnah', '=', 1)
            ->count();

        return (bool) ($ret > 0);
    }

    public function getCostByType($costtypeId, Realestate $realestate){
        return Cost::where('realestate_id','=', $realestate->id)
            ->where(function (Builder $query) use ($realestate) {
                if ($realestate->abrechnungssetting != null) {
                    $query->where('periodTo', '=', null)
                        ->orWhere('periodTo', '>=', $realestate->abrechnungssetting->periodFrom);
                }
            })
            ->where(function (Builder $query) use ($realestate) {
                if ($realestate->abrechnungssetting != null) {
                    $query->where('periodFrom', '<=', $realestate->abrechnungssetting->periodTo);
                }
            })
            ->where(function (Builder $query) {$query->IsHeizkosten();})
            ->where('costtype_id','=',$costtypeId)
            ->get()->sortBy('caption');
    }

}
