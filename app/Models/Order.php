<?php

namespace App\Models;

use App\Enums\OrderPaymentStatusEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasUlids;
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'discount',
        'total',
        'payment_status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatusEnum::class,
            'payment_status' => OrderPaymentStatusEnum::class,
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }}
