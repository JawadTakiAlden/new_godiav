<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BranchSupplier>
 */
class BranchSupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'branch_id' => $this->faker->numberBetween(1,10),
            'supplier_id' => $this->faker->numberBetween( 1 , 20)
        ];
    }
}
