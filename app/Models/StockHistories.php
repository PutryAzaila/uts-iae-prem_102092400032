<?php
namespace App\Models;

use App\Enums\StockAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockHistories extends Model
{
    protected $fillable = [
        'product_account_id', 'action_type', 'description', 'order_id'
    ];

    protected $casts = [
        'action_type' => StockAction::class,
    ];

    public function productAccount(): BelongsTo
    {
        return $this->belongsTo(ProductAccount::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}