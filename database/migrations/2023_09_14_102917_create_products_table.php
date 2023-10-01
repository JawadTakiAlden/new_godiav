<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('description');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->double('price');
            $table->boolean('visibility')->default(true);
            $table->double('calories');
<<<<<<< HEAD
            $table->double('estimated_time')->default(1);
=======
            $table->integer('estimated_time')->default(5);
>>>>>>> c06455dc74efb38a554ec9dd796c192b53eaa3ef
            $table->foreignId('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
