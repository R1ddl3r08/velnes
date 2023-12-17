<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Service::create([
            'name' => 'Haircut',
            'service_category_id' => 1,
            'price' => 20,
            'duration' => 30,
            'bookable_online' => 1
        ]);
        Service::create([
            'name' => 'Hair Coloring',
            'service_category_id' => 1,
            'price' => 40,
            'duration' => 60,
            'bookable_online' => 1
        ]);
        Service::create([
            'name' => 'Manicure',
            'service_category_id' => 2,
            'price' => 30,
            'duration' => 60,
            'bookable_online' => 1
        ]);
        Service::create([
            'name' => 'Pedicure',
            'service_category_id' => 2,
            'price' => 30,
            'duration' => 60,
            'bookable_online' => 1
        ]);
        Service::create([
            'name' => 'Chemical Peel',
            'service_category_id' => 3,
            'price' => 50,
            'duration' => 30,
            'bookable_online' => 1
        ]);
        Service::create([
            'name' => 'Skin consultation',
            'service_category_id' => 3,
            'price' => 20,
            'duration' => 15,
            'bookable_online' => 1
        ]);
        Service::create([
            'name' => 'Swedish massage',
            'service_category_id' => 4,
            'price' => 60,
            'duration' => 60,
            'bookable_online' => 1
        ]);
        Service::create([
            'name' => 'Hot stone massage',
            'service_category_id' => 4,
            'price' => 80,
            'duration' => 60,
            'bookable_online' => 1
        ]);
    }
}
