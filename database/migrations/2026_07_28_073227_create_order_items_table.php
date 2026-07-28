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
        Schema::create('order_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('order_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid('product_id')
                ->constrained()
                ->restrictOnDelete();
            $table->string('title');
            $table->unsignedBigInteger('price');
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('total');
            $table->timestamps();
            $table->index('order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
