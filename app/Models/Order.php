<?php
namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'public_token', 'customer_name', 'customer_phone',
        'customer_email', 'product_id',
        'total_amount', 'status', 'expired_at'
    ];

    protected $casts = [
        'status'     => OrderStatus::class,
        'expired_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productAccount(): HasOne
    {
        return $this->hasOne(ProductAccount::class, 'order_id', 'id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function isPaid(): bool
    {
        return $this->status === OrderStatus::Paid;
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_code  = $order->order_code  ?? 'ORD-' . strtoupper(Str::random(8));
            $order->public_token = $order->public_token ?? Str::random(64);
            $order->expired_at  = $order->expired_at  ?? now()->addHours(24);
        });
    }
}