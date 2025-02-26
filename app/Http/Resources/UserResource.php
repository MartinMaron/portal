<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'password' => $this->password,
            'kundennummer' => $this->kundennummer,
          ];
    }
}

     
