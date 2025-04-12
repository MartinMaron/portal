<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class OccupantMobileResource extends JsonResource
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
            'nutzeinheitNo' => $this->nutzeinheitNo,
            'dateFrom' => new DateTime($this->dateFrom),
            'dateTo' => $this->dateTo,
            'anrede' => $this->anrede,
            'title' => $this->title,
            'nachname' => $this->nachname,
            'vorname' => $this->vorname,
            'address' => $this->address,
            'street' => $this->street,
            'city' => $this->city,
            'houseNr' => $this->houseNr,
            'postcode' => $this->postcode,
            'lokalart' => $this->lokalart,
            'customEinheitNo' => $this->customEinheitNo,
            'lage' => $this->lage,
            'counterMeters' => $this->counterMeters,
            'visibleVerbrauchsinfos' => $this->visibleVerbrauchsinfos(),
            'email' => $this->email,
        ];
    }
}
