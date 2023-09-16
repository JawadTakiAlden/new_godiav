<?php

use App\Types\UserTypes;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('serial_number')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->foreignId('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('type')->default(UserTypes::WAITER);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
