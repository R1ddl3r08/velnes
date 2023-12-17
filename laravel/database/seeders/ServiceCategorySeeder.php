<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $serviceCategories = ['Hair', 'Nails', 'Skin care', 'Body'];
        $colors = ['#FFA78A', '#9B839F', '#FFCC7E', '#48B3AC'];

        $colorIndex = 0;
        foreach($serviceCategories as $category){
            ServiceCategory::create([
                'name' => $category,
                'color' => $colors[$colorIndex],
            ]);
            $colorIndex++;
        }
    }
}
