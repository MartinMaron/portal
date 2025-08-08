<?php

namespace App\Http\Traits\Helper;
use App\Models\Cost;
use App\Models\CostAmount;
use App\Models\Realestate;
use Illuminate\Database\Eloquent\Builder;

trait CostHelper
{
    public function makeBlankObject(Cost $cost)
    {
        return Cost::make([
            'nekoId' => 0,
            'co2Tax' => $cost->co2Tax,
            'realestate_id' => $cost->realestate->id,
            'costtype_id' => $cost->costtype_id,
            'consumption' => false,
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
            'haushaltsnah' => true,
            'costkey_id' => $realestate->costsKeys->where('viewText', '=', 'Wohnfläche')->first()->id ?? null,
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
        if ($object['costtype_id'] == 'BEK') {
            $cost->realestate_id = $object['realestate_id'];
            $cost->costtype_id = $object['costtype_id'];
            $cost->consumption = $object['consumption'];
            $cost->nekoId = $object['nekoId'];
            $cost->caption = $object['caption'];
            $cost->haushaltsnah = $object['haushaltsnah'];
            $cost->co2Tax = $object['co2Tax'];
            $cost->costkey_id = $object['costkey_id'];
            $cost->noticeForNeko = $object['noticeForNeko'];
            $cost->OptimisticLockField = $cost->OptimisticLockField + 1;
        } else {
            $cost->caption = $object->caption;}
        return $cost;
    }

    public function upsertCost(Cost $cost)
    {
       $cost->save();
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
            })
            ->where('costtype_id', '=', $costtypeId)
            ->where('haushaltsnah', '=', 1)
            ->count();

        return (bool) ($ret > 0);
    }


}
