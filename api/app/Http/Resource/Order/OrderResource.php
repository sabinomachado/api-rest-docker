<?php

namespace App\Http\Resource\Order;

use App\Http\Resource\City\CityResourceLight;
use App\Http\Resource\Client\ClientResourceLight;
use App\Http\Resource\User\UserResourceLight;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'city' => new CityResourceLight($this->city),
            'client' => new ClientResourceLight($this->client),
            'seller' => new UserResourceLight($this->user),
            'boarding_date' => $this->boarding_date,
            'return_date' => $this->return_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
