<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'rg' => $this->faker->bothify('##.###.###'),
            'cpf' => $this->faker->bothify('###.###.###-##'),
            'birth_date' => $this->faker->date(),
        ];
    }
}
