<?php
namespace App\Models;

use App\Enums\AccountStatus;
use App\Enums\StockAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAccount extends Model
{
    protected $fillable = [
        'product_id', 'account_email_or_username',
        'account_password', 'notes', 'status', 'order_id'
    ];

    protected $casts = [
        'status' => AccountStatus::class,
    ];

    // Sembunyikan kredensial dari serialisasi default
    protected $hidden = ['account_email_or_username', 'account_password'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function stockHistories(): HasMany
    {
        return $this->hasMany(StockHistories::class);
    }

    // Hanya expose kredensial jika dipanggil eksplisit
    public function makeCredentialsVisible(): static
    {
        return $this->makeVisible(['account_email_or_username', 'account_password']);
    }
}