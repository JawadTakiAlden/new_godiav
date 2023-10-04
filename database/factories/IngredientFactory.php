<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unit = ['g' , 'kg'];
        $quantity = $this->faker->numberBetween(0 , 200000);
        return [
            'name' => $this->faker->name,
            'quantity' => $quantity ,
            'should_notify_quantity' => $this->faker->numberBetween(0 , $quantity),
            'base_unit' => $unit[rand(0 , count($unit) )],
            'branch_id' => $this->faker->numberBetween(1 , 10)
        ];
    }
}
