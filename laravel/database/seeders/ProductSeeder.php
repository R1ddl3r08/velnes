<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productNames = [
            'Soothing Massage Oil',
            'Professional Hair Styling Spray',
            'Gel Nail Polish Set',
            'Hydrating Facial Mask',
            'Long-Wear Matte Lipstick',
        ];

        foreach ($productNames as $index => $productName) {
            $productCategory = DB::table('product_categories')->where('name', $this->getCategoryName($index))->first();

            $vats = ['5', '10', '15'];
            $randomVat = $vats[array_rand($vats)];

            Product::create([
                'name' => $productName,
                'product_category_id' => $productCategory->id,
                'price' => rand(10, 100),
                'cost_price' => rand(10, 100),
                'part_number' => rand(1000, 9999),
                'vat' => $randomVat,
                'quantity' => rand(1, 50),
            ]);
        }
    }

    private function getCategoryName($index)
    {
        $productCategories = ['Body', 'Hair', 'Nails', 'Skin care', 'Makeup'];
        return $productCategories[$index];
    }
}
