<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const PLACEHOLDER_IMAGE = 'assets/images/product-placeholder.svg';

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

    /**
     * Public URL of the product image, or the default placeholder when none is uploaded.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->image
            ? asset('storage/'.$this->image)
            : asset(self::PLACEHOLDER_IMAGE));
    }
}
