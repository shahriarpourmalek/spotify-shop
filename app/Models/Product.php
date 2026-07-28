<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasUlids;
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'is_active',
        'sort',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'integer',
        'sort' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }}
