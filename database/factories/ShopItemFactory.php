<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShopItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'stock' => $this->faker->numberBetween(1, 100),
            'point_cost' => $this->faker->numberBetween(10, 500),
        ];
    }
}
