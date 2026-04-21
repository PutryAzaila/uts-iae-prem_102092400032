<?php

namespace Database\Seeders;

use App\Models\ProductAccount;
use Illuminate\Database\Seeder;

class ProductAccountSeeder extends Seeder
{
    public function run(): void
    {
        ProductAccount::insert([
            [
                'product_id' => 1,
                'email' => 'netflix1@example.com',
                'username' => null,
                'password' => 'nfpass_001',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'email' => 'netflix2@example.com',
                'username' => null,
                'password' => 'nfpass_002',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'email' => 'spotify1@example.com',
                'username' => null,
                'password' => 'sppass_001',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}