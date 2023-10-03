<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\BranchSupplier;
use App\Models\Ingredient;
use App\Models\IngredientSupplier;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
           'name' => 'admin',
           'email' => 'admin@gmail.com',
           'password' => 'admin123',
           'type' => UserTypes::ADMIN
        ]);

        $branch1 = Branch::create([
           'name' => 'branch one'
        ]);
        $branch2 =  Branch::create([
            'name' => 'branch two'
        ]);
        $branch3 =  Branch::create([
            'name' => 'branch three'
        ]);


        $supplier1 = Supplier::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'father_name' => 'Richard',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'phone' => '555-1234',
        ]);

        $supplier2 = Supplier::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'father_name' => 'Henry',
            'email' => 'janesmith@example.com',
            'password' => 'password456',
            'phone' => '555-5678',
        ]);


        $supplier3 = Supplier::create([
            'first_name' => 'Bob',
            'last_name' => 'Johnson',
            'father_name' => 'Michael',
            'email' => 'bobjohnson@example.com',
            'password' => 'password789',
            'phone' => '555-9012',
        ]);


        $supplier4 = Supplier::create([
            'first_name' => 'Mary',
            'last_name' => 'Williams',
            'father_name' => 'John',
            'email' => 'marywilliams@example.com',
            'password' => 'password321',
            'phone' => '555-3456',
        ]);

        BranchSupplier::create([
           'branch_id' =>  $branch1->id,
            'supplier_id' => $supplier1->id
        ]);
        BranchSupplier::create([
            'branch_id' =>  $branch1->id,
            'supplier_id' => $supplier2->id
        ]);
        BranchSupplier::create([
            'branch_id' =>  $branch1->id,
            'supplier_id' => $supplier3->id
        ]);
        BranchSupplier::create([
            'branch_id' =>  $branch1->id,
            'supplier_id' => $supplier4->id
        ]);

        BranchSupplier::create([
            'branch_id' =>  $branch2->id,
            'supplier_id' => $supplier1->id
        ]);
        BranchSupplier::create([
            'branch_id' =>  $branch2->id,
            'supplier_id' => $supplier2->id
        ]);
        BranchSupplier::create([
            'branch_id' =>  $branch2->id,
            'supplier_id' => $supplier3->id
        ]);

        BranchSupplier::create([
            'branch_id' =>  $branch3->id,
            'supplier_id' => $supplier1->id
        ]);


        $ingredient1 = Ingredient::create([
           'name' => 'ingredient one',
           'should_notify_quantity' => 5000 ,
            'quantity' => 10000,
            'base_unit' => 'kg',
            'branch_id' => $branch1->id
        ]);
        $ingredient2 = Ingredient::create([
            'name' => 'ingredient two',
            'should_notify_quantity' => 5000 ,
            'quantity' => 20000,
            'base_unit' => 'kg',
            'branch_id' => $branch1->id
        ]);

        $ingredient3 = Ingredient::create([
            'name' => 'ingredient three',
            'should_notify_quantity' => 5000 ,
            'quantity' => 400000,
            'base_unit' => 'kg',
            'branch_id' => $branch1->id
        ]);

        $ingredient4 = Ingredient::create([
            'name' => 'ingredient four',
            'quantity' => 20000,
            'should_notify_quantity' => 5000 ,
            'base_unit' => 'kg',
            'branch_id' => $branch2->id
        ]);

        $ingredient5 = Ingredient::create([
            'name' => 'ingredient five',
            'quantity' => 400000,
            'should_notify_quantity' => 5000 ,
            'base_unit' => 'kg',
            'branch_id' => $branch2->id
        ]);

        $ingredient6 = Ingredient::create([
            'name' => 'ingredient sex',
            'quantity' => 400000,
            'should_notify_quantity' => 5000 ,
            'base_unit' => 'kg',
            'branch_id' => $branch3->id
        ]);

        IngredientSupplier::create([
           'supplier_id' => $supplier1->id,
           'branch_id' => $branch1->id,
           'ingredient_id' =>  $ingredient1->id,
            'come_in_quantity' => 200000,
            'unit' => 'kg',
            'total_price' => 250000
        ]);
        IngredientSupplier::create([
            'supplier_id' => $supplier1->id,
            'branch_id' => $branch1->id,
            'ingredient_id' =>  $ingredient2->id,
            'come_in_quantity' => 100000,
            'unit' => 'kg',
            'total_price' => 300000
        ]);


        IngredientSupplier::create([
            'supplier_id' => $supplier1->id,
            'branch_id' => $branch1->id,
            'ingredient_id' =>  $ingredient3->id,
            'come_in_quantity' => 150000,
            'unit' => 'kg',
            'total_price' => 360000
        ]);
    }
}
