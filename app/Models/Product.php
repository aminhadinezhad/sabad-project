<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'category',
        'brand_id',
        'unit',
        'price',
        'image',
        'vat_enabled',
        'vat_percentage',
    ];

    protected $casts = [
        'vat_enabled' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}