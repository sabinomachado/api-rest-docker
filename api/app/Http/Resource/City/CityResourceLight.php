<?php

namespace App\Http\Resource\City;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResourceLight extends JsonResource
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
        ];
    }
}
