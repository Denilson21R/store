<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition()
    {
        $clients = Client::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        return [
            'id_user' => $this->faker->randomElement($users),
            'id_client' => $this->faker->randomElement($clients),
            'total_value' => $this->faker->randomFloat(2, 0, 999999)
        ];
    }
}
