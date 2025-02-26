<?php

namespace App\Http\Resources;

use App\Models\Einheit;
use App\Models\UserVerbrauchsinfoAccessControl;
use App\Models\ZaehlerArt;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMobileRessource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'isUser' => $this->isUser,
            'isAdmin' => $this->isAdmin,
            'isMieter' => $this->isMieter,
            'kundennummer' => $this->kundennummer,
            'occupants'=> $this->getOccupants(),
            'einheiten'=> $this->getEinheiten(),
            'zaehlerarten'=> $this->getZaehlerarten(),
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
        $result =  $user->userVerbrauchsinfoAccessControls->map(function (UserVerbrauchsinfoAccessControl $userControl) {
            return new OccupantMobileResource($userControl->occupant);
        })->unique();
        return $result;
    }

}

     
