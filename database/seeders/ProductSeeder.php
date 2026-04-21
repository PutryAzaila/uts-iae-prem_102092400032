<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name'        => 'Netflix Premium 1 Bulan',
                'slug'        => 'netflix-premium-1-bulan',
                'price'       => 150000,
                'description' => 'Akun Netflix Premium shared, 1 bulan penuh.',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Spotify Premium 1 Bulan',
                'slug'        => 'spotify-premium-1-bulan',
                'price'       => 99000,
                'description' => 'Akun Spotify Premium, 1 bulan penuh.',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}