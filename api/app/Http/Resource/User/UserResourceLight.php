<?php

namespace App\Http\Resource\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceLight extends JsonResource
{
    /**
     * Transform the resource into an array
     *
     * @param Request $request
     */

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
