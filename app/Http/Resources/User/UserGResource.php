<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserGResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            "surname" => $this->resource->surname,
            "email" => $this->resource->email,
            "avatar" => !$this->resource->avatar ? NULL : env("APP_URL")."storage/". $this->resource->avatar,
            "role_id" => $this->resource->role_id,
            "state" => $this->resource->state ?? 1,
            "type_user" => $this->resource->type_user,
        ];
    }
}
