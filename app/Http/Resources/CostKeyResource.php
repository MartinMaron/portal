<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CostKeyResource extends JsonResource
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
            'nekocostkey_id' => $this['nekocostkeyId'],
            'nekoKey_id' => $this['nekoKeyId'],
            'bemerkung' => $this['bemerkung'],
            'tryWebDelete' => $this['tryWebDelete'],
            'description' => $this['description'],
            'zeitanteil' => $this['zeitanteil'],
            'einheit' => $this['einheit'],
            'shortKey' => $this['shortKey'],
            'viewText' => $this['viewText'],
        ];
    }
}
