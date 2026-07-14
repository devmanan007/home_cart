<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@home-cart.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Customer',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        $gheeCategory = Category::updateOrCreate(
            ['slug' => 'homemade-ghee'],
            [
                'name' => 'Homemade Ghee',
                'description' => 'Pure, traditional homemade ghee made from the finest cow milk.',
                'is_active' => true,
            ]
        );

        $mangoCategory = Category::updateOrCreate(
            ['slug' => 'seasonal-mangoes'],
            [
                'name' => 'Seasonal Mangoes',
                'description' => 'Fresh, hand-picked seasonal mangoes from the best orchards.',
                'is_active' => true,
            ]
        );

        $gheeProducts = [
            [
                'category_id' => $gheeCategory->id,
                'name' => 'A2 Cow Ghee',
                'slug' => 'a2-cow-ghee',
                'description' => 'Premium A2 cow ghee made using the traditional bilona method. Rich aroma and grainy texture. Perfect for cooking and daily meals.',
                'short_description' => 'Premium A2 cow ghee made using the traditional bilona method.',
                'price' => 899.00,
                'sale_price' => 799.00,
                'stock_quantity' => 150,
                'sku' => 'GHEE-A2-500',
                'weight' => 0.50,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $gheeCategory->id,
                'name' => 'Desi Gir Cow Ghee',
                'slug' => 'desi-gir-cow-ghee',
                'description' => 'Authentic Gir cow ghee sourced from free-grazing Gir cows. Deep golden color and intense nutty flavor.',
                'short_description' => 'Authentic Gir cow ghee with deep golden color and nutty flavor.',
                'price' => 1199.00,
                'sale_price' => null,
                'stock_quantity' => 80,
                'sku' => 'GHEE-GIR-500',
                'weight' => 0.50,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $gheeCategory->id,
                'name' => 'Organic Buffalo Ghee',
                'slug' => 'organic-buffalo-ghee',
                'description' => 'Rich and creamy buffalo ghee made from organic buffalo milk. Perfect for sweets and traditional cooking.',
                'short_description' => 'Rich and creamy organic buffalo ghee for traditional cooking.',
                'price' => 749.00,
                'sale_price' => null,
                'stock_quantity' => 100,
                'sku' => 'GHEE-BUF-500',
                'weight' => 0.50,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $gheeCategory->id,
                'name' => 'A2 Cow Ghee - 1 Litre',
                'slug' => 'a2-cow-ghee-1-litre',
                'description' => 'Our bestselling A2 cow ghee in a family-size 1 litre jar. Same traditional quality, better value.',
                'short_description' => 'Family-size 1 litre jar of premium A2 cow ghee.',
                'price' => 1599.00,
                'sale_price' => 1399.00,
                'stock_quantity' => 60,
                'sku' => 'GHEE-A2-1000',
                'weight' => 1.00,
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        $mangoProducts = [
            [
                'category_id' => $mangoCategory->id,
                'name' => 'Alphonso Mangoes (Dozen)',
                'slug' => 'alphonso-mangoes-dozen',
                'description' => 'Premium Alphonso mangoes hand-picked from Ratnagiri orchards. Known as the King of Mangoes for their rich, sweet, and creamy taste.',
                'short_description' => 'Premium Alphonso mangoes from Ratnagiri. The King of Mangoes.',
                'price' => 1200.00,
                'sale_price' => 999.00,
                'stock_quantity' => 200,
                'sku' => 'MANGO-ALF-12',
                'weight' => 3.00,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $mangoCategory->id,
                'name' => 'Kesar Mangoes (Dozen)',
                'slug' => 'kesar-mangoes-dozen',
                'description' => 'Sweet and aromatic Kesar mangoes from Junagadh, Gujarat. Bright orange flesh with a distinctive saffron-like flavor.',
                'short_description' => 'Sweet Kesar mangoes from Junagadh with saffron-like flavor.',
                'price' => 800.00,
                'sale_price' => null,
                'stock_quantity' => 250,
                'sku' => 'MANGO-KES-12',
                'weight' => 3.00,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'category_id' => $mangoCategory->id,
                'name' => 'Dasheri Mangoes (Dozen)',
                'slug' => 'dasheri-mangoes-dozen',
                'description' => 'Famous Dasheri mangoes from Lucknow. Small to medium sized with extremely sweet, fiberless flesh.',
                'short_description' => 'Famous Lucknow Dasheri mangoes. Sweet and fiberless.',
                'price' => 600.00,
                'sale_price' => 549.00,
                'stock_quantity' => 300,
                'sku' => 'MANGO-DAS-12',
                'weight' => 2.50,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'category_id' => $mangoCategory->id,
                'name' => 'Totapuri Mangoes (5kg Box)',
                'slug' => 'totapuri-mangoes-5kg',
                'description' => 'Fresh Totapuri mangoes in a 5kg family box. Tangy and sweet, perfect for making juices, pickles, and Aam Panna.',
                'short_description' => '5kg box of Totapuri mangoes. Great for juices and pickles.',
                'price' => 450.00,
                'sale_price' => null,
                'stock_quantity' => 120,
                'sku' => 'MANGO-TOT-5KG',
                'weight' => 5.00,
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach (array_merge($gheeProducts, $mangoProducts) as $data) {
            Product::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
