<?php


use App\Types\OrderTypes;
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
        Schema::create('sub_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->tinyInteger('order_state')->default(OrderTypes::WAITING);
            $table->foreignId('table_id')->references('id')->on('tables');
            $table->double('total')->default(0);
            $table->double('estimated_time')->default(1);
            $table->time('delay_time')->default('00:00:00');
            $table->time('early_time')->default('00:00:00');
            $table->foreignId('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_orders');
    }
};
