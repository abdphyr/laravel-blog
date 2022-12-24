<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "username" =>  $this->username,
            "email" =>  $this->email,
            "avatar" =>  $this->avatar,
            "info" => $this->info,
            "roles" => RoleResource::collection($this->roles)
        ];
    }
}
