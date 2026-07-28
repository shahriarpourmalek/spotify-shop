<?php

use App\Enums\OrderPaymentStatusEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum(
                'status',
                array_column(OrderStatusEnum::cases(), 'value')
            )->default(OrderStatusEnum::PENDING->value);
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('total')->default(0);
            $table->enum(
                'payment_status',
                array_column(OrderPaymentStatusEnum::cases(), 'value')
            )->default(OrderPaymentStatusEnum::PENDING->value);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
            $table->index('payment_status');
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
