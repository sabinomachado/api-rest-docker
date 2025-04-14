<?php

namespace Database\Factories;

use App\Enum\OrderStatusEnum;
use App\Models\Order;
use App\Models\Client;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'id_client' => Client::factory(),
            'id_city' => City::factory(),
            'id_user' => User::factory(),
            'boarding_date' => $this->faker->date(),
            'return_date' => $this->faker->date(),
            'status' => OrderStatusEnum::random(),
        ];
    }
}
