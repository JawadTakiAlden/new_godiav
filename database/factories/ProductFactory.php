<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'category_id' => $this->faker->numberBetween(1,50),
            'price' => $this->faker->numberBetween(10 , 200),
            'calories' => $this->faker->numberBetween(20 , 1000),
            'estimated_time' => $this->faker->numberBetween(1 , 20),
            'branch_id' =>  $this->faker->numberBetween( 1 , 10),
        ];
    }
}
