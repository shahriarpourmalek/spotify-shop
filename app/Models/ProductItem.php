<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductItem extends Model
{
    use HasUlids;
    protected $fillable = [
        'product_id',
        'username',
        'password',
        'extra',
        'status',
        'sold_at',
    ];

    protected function casts(): array
    {
        return [
            'extra' => 'array',
            'sold_at' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
