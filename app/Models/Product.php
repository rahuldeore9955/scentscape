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
        'description',
        'short_description',
        'price',
        'size',
        'category',   // women, men, unisex
        'badge',      // bestseller, new, sale
        'status',     // active, inactive
        'image',
        'images',     // JSON array of additional images
        'fragrance_notes', // JSON: top, middle, base
    ];

    protected $casts = [
        'images'         => 'array',
        'fragrance_notes' => 'array',
        'price'          => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::created(function (Product $product) {
            $product->forceFill(['sku' => self::productId($product->id)])->saveQuietly();
        });
    }

    public static function productId(int $id): string
    {
        return 'SC-'.str_pad((string) $id, 3, '0', STR_PAD_LEFT);
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
