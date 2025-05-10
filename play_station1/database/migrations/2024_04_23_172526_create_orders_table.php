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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('game_id');
            $table->integer('quantity')->unsigned();
            $table->decimal('total_price', 8, 2);
            $table->enum('status', [
                'pending', 'processing', 'completed',
                'canceled'
            ]);
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
