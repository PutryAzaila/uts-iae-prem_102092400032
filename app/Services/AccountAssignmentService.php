<?php

namespace App\Services;

use App\Enums\AccountStatus;
use App\Enums\StockAction;
use App\Models\Order;
use App\Models\ProductAccount;
use App\Models\StockHistories;
use Illuminate\Support\Facades\DB;

class AccountAssignmentService
{
    public function assignToOrder(Order $order): ProductAccount
    {
        return DB::transaction(function () use ($order) {
            $existingAccount = ProductAccount::where('order_id', $order->id)->first();

            if ($existingAccount) {
                return $existingAccount;
            }

            $account = ProductAccount::where('product_id', $order->product_id)
                ->where('status', AccountStatus::Available)
                ->whereNull('order_id')
                ->lockForUpdate()
                ->first();

            if (!$account) {
                throw new \RuntimeException('Stok akun habis. Hubungi admin.');
            }

            $account->update([
                'status'   => AccountStatus::Sold,
                'order_id' => $order->id,
            ]);

            StockHistories::create([
                'product_account_id' => $account->id,
                'action_type'        => StockAction::Sold,
                'description'        => "Akun diberikan ke order {$order->order_code}",
                'order_id'           => $order->id,
            ]);

            return $account;
        });
    }

    public function releaseFromOrder(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $account = ProductAccount::where('order_id', $order->id)->first();

            if (!$account) {
                return;
            }

            $account->update([
                'status'   => AccountStatus::Available,
                'order_id' => null,
            ]);

            StockHistories::create([
                'product_account_id' => $account->id,
                'action_type'        => StockAction::Released,
                'description'        => "Akun dilepas dari order {$order->order_code} — status: {$order->status->value}",
                'order_id'           => $order->id,
            ]);
        });
    }
}