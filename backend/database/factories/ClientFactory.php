<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{

    protected $model = Client::class;
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        return [
            'name' => $this->faker->name($gender),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
