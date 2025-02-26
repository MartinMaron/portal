<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CostkeyResource extends JsonResource
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
            'nekocostkey_id'=> $this['nekocostkeyId'],
            'nekoKey_id'=> $this['nekoKeyId'],            
            'bemerkung'=> $this['bemerkung'],
            'tryWebDelete'=> $this['tryWebDelete'],
            'description'=> $this['description'],
            'zeitanteil'=> $this['zeitanteil'],
            'einheit'=> $this['einheit'],
            'shortKey'=> $this['shortKey'],
            'viewText'=> $this['viewText'],  
        ];
    }
}
