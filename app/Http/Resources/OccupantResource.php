<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupantResource extends JsonResource
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

            "nekoId"=> $this->nekoId,
            "unvid"=> $this->unvid,
            "budguid" => $this->budguid,
            "nutzeinheitNo" => $this->nutzeinheitNo,
            "dateFrom" => new DateTime($this->dateFrom),
            "dateTo" => $this->dateTo,
            "anrede" => $this->anrede,
            "title" => $this->title,
            "nachname" => $this->nachname,
            "vorname" => $this->vorname,
            "address" => $this->address,
            "street" => $this->street,
            "city" => $this->city,
            "houseNr" => $this->houseNr,
            "postcode" => $this->postcode,
            "vat" => $this->vat,
            "uaw" => $this->uaw,
            "qmkc" => $this->qmkc,
            "qmww" => $this->qmww,
            "pe" => $this->pe,
            "bemerkung" => $this->bemerkung,
            "vorauszahlung" => $this->vorauszahlung,
            "lokalart" => $this->lokalart,
            "customEinheitNo" => $this->customEinheitNo,
            "lage" => $this->lage,
            "counterMeters" => $this->counterMeters,
            "email" => $this->email,
        ];
    }
}
