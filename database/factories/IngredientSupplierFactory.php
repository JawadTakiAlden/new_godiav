<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientSupplier>
 */
class IngredientSupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unit = ['g' , 'kg'];
        $come_in_quantity = $this->faker->numberBetween(100 , 200000);
        $unit_price = 10;
        return [
            'supplier_id' => $this->faker->numberBetween( 1 , 20),
            'ingredient_id' => $this->faker->numberBetween( 1 , 100),
            'branch_id' =>  $this->faker->numberBetween( 1 , 10),
            'come_in_quantity' => $come_in_quantity,
            'unit' => $unit[rand(0 , count($unit) )],
            'total_price' => $come_in_quantity * $unit_price
        ];
    }
}
