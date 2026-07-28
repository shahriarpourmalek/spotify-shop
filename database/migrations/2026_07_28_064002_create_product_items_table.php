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
        Schema::create('product_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('product_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('username')->nullable();
            $table->text('password')->nullable();
            $table->json('extra')->nullable();
            $table->enum('status', [
                'Available',
                'Sold',
                'Expired',
                'Disabled',
            ])->default('Available');
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
            $table->index(['product_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
