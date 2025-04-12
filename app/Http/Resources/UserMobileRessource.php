<?php

namespace App\Http\Resources;

use App\Models\Einheit;
use App\Models\UserVerbrauchsinfoAccessControl;
use App\Models\ZaehlerArt;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserMobileRessource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'isUser' => $this->isUser,
            'isAdmin' => $this->isAdmin,
            'isMieter' => $this->isMieter,
            'kundennummer' => $this->kundennummer,
            'occupants' => $this->getOccupants(),
            'einheiten' => $this->getEinheiten(),
            'zaehlerarten' => $this->getZaehlerarten(),
        ];
    }

    public function getEinheiten()
    {
        return Einheit::all();
    }

    public function getZaehlerarten()
    {
        return ZaehlerArt::all();
    }

    public function getOccupants()
    {
        $user = auth()->user();
        $result = $user->userVerbrauchsinfoAccessControls->map(function (UserVerbrauchsinfoAccessControl $userControl) {
            return new OccupantMobileResource($userControl->occupant);
        })->unique();

        return $result;
    }
}
