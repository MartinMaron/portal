<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbrechnungssettingResource extends JsonResource
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
