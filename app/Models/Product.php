<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'price', 'description', 'is_active', 'thumbnail'
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(ProductAccount::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function availableAccounts(): HasMany
    {
        return $this->hasMany(ProductAccount::class)
                    ->where('status', 'available');
    }

    public function getAvailableStockCountAttribute(): int
    {
        return $this->availableAccounts()->count();
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = str($product->name)->slug();
            }
        });
    }
}