<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class RealestateResource extends JsonResource
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
            'email' => $this['email'],
            'address' => $this['address'],
            'unvid' => $this['unvid'],
            'street' => $this['street'],
            'postCode' => $this['postCode'],
            'city' => $this['city'],
            'heizkosten' => $this['heizkosten'],
            'rauchmelder' => $this['rauchmelder'],
            'dateFrom' => $this['dateFrom'],
            'dateTo' => $this['dateTo'],
            'miete' => $this['miete'],
            'nekoToWebUpdate' => $this['nekoToWebUpdate'],
            'occupants' => $this['occupants'],
            'costs' => $this['costs'],
            'costsKeys' => $this['costsKeys'],
            'abrechnungsettings' => $this['abrechnungsettings'],
            'verbrauchsinfoUserEmails' => $this['verbrauchsinfoUserEmails'],
            'verbrauchsinfoAccessControls' => $this['verbrauchsinfoAccessControls'],
            'invoices' => $this['invoices'],
        ];
    }
}
