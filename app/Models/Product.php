<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'description',
        'short_description',
        'price',
        'original_price',
        'size',
        'category',   // women, men, unisex
        'badge',      // bestseller, new, sale
        'status',     // active, draft, out_of_stock
        'image',
        'images',     // JSON array of additional images
        'sku',
        'fragrance_notes', // JSON: top, middle, base
    ];

    protected $casts = [
        'images'         => 'array',
        'fragrance_notes' => 'array',
        'price'          => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
