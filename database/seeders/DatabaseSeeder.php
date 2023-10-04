<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\BranchSupplier;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Ingredient;
use App\Models\IngredientSupplier;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Types\UserTypes;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Branch::factory(10)->create();
        Ingredient::factory(100)->create();
        Supplier::factory(20)->create();
        IngredientSupplier::factory(200)->create();
        Category::factory(50)->create();
        BranchSupplier::factory(20)->create();
        Employee::factory()->create();
        Product::factory(100)->create();
    }
}
