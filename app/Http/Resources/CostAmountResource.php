<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CostAmountResource extends JsonResource
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
            'bemerkung' => $this['bemerkung'],
            'tryWebDelete' => $this['tryWebDelete'],
            'description' => $this['description'],
            'netAmount' => $this['netAmount'],
            'grosAmount' => $this['grosAmount'],
            'dateCostAmount' => $this['dateCostAmount'],
            'consumption' => $this['consumption'],
            'grosAmount_HH' => $this['grosAmount_HH'],
        ];
    }
}
