<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'nekoId' => $this['nekoId'],
            'unvid' => $this['unvid'],
            'budguid' => $this['budguid'],
            'nazwa' => $this['nazwa'],
            'bemerkung' => $this['bemerkung'],
            'tryWebDelete' => $this['tryWebDelete'],
            'costtype_id' => $this['costtype_id'],
            'vatAmount' => $this['vatAmount'],
            'fueltype_id' => $this['fueltype_id'],
            'hasTank' => $this['hasTank'],
            // Anfangsstand
            'startValue' => $this['startValue'],
            // Endstand
            'endValue' => $this['endValue'],
            // Wert des Brennstofs
            'startValueAmount' => $this['startValueAmount'],
            'haushaltsnah' => $this['haushaltsnah'],
            'keyId' => $this['keyId'],
            'keyName' => $this['keyName'],
            'keyShortkey' => $this['keyShortkey'],
            'noticeForUser' => $this['noticeForUser'],
            'noticeForNeko' => $this['noticeForNeko'],
            'costAbrechnungType' => $this['costAbrechnungType'],
            'costAbrechnungTypeId' => $this['costAbrechnungTypeId'],
            'startValueAmountNet' => $this['startValueAmountNet'],
            'startValueAmountGros' => $this['startValueAmountGros'],
            'keyUnitType' => $this['keyUnitType'],
            'consumption' => $this['consumption'],
            'costamounts' => $this['costamounts'],
        ];
    }
}
