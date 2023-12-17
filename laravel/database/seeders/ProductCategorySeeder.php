<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsCategories = ['Body', 'Hair', 'Nails', 'Skin care', 'Makeup'];

        foreach($productsCategories as $productCategory){
            ProductCategory::create([
                'name' => $productCategory
            ]);
        }
    }
}
