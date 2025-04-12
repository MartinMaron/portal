<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class RealestateAbrechnungssettingResource extends JsonResource
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
            'neko_id' => $this['neko_id'],
            'bemerkung' => $this['bemerkung'],
            'tryWebDelete' => $this['tryWebDelete'],
            'description' => $this['description'],
            'nabi_inhaber' => $this['nabi_inhaber'],
            'nabi_nr' => $this['nabi_nr'],
            'stromkosten' => $this['stromkosten'],
            'brenwert_gasabrechnug' => $this['brenwert_gasabrechnug'],
            'eigen_energielieferung' => $this['eigen_energielieferung'],
            'aktiv' => $this['aktiv'],
        ];
    }
}
