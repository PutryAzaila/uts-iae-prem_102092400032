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
        'product_id', 'email', 'username', 'password',
        'notes', 'status', 'order_id'
    ];

    protected $casts = [
        'status' => AccountStatus::class,
    ];

    protected $hidden = ['email', 'username', 'password'];

    protected $appends = ['account_email_or_username', 'account_password'];

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

    public function makeCredentialsVisible(): static
    {
        return $this->makeVisible(['email', 'username', 'password']);
    }

    public function getAccountEmailOrUsernameAttribute(): ?string
    {
        return $this->email ?: $this->username;
    }

    public function getAccountPasswordAttribute(): ?string
    {
        return $this->password;
    }
}