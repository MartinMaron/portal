<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CostAmountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'bemerkung'=> $this['bemerkung'],
            'tryWebDelete'=> $this['tryWebDelete'],
            'description'=> $this['description'],
            'netAmount'=> $this['netAmount'],
            'grosAmount'=> $this['grosAmount'],
            'dateCostAmount'=> $this['dateCostAmount'],
            'consumption'=> $this['consumption'],
            'grosAmount_HH'=> $this['grosAmount_HH']
        ];
    }
}
