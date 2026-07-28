<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasUlids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }}
