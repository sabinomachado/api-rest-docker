<?php

namespace App\Http\Resource\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResourceLight extends JsonResource
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
