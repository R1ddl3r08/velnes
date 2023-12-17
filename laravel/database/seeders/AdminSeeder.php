<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $picturePath = $faker->image(storage_path('app/public/profile_pictures'), 200, 200, 'people', false);
        User::create([
            'full_name' => 'admin',
            'company_name' => 'Brainster',
            'work_email' => 'admin@gmail.com',
            'phone_number' => '+38978261257',
            'password' => 'Admin123$',
            'is_trial' => 0,
            'role_id' => 1,
            'photo_url' => 'profile_pictures/' . pathinfo($picturePath, PATHINFO_BASENAME),
        ]);
    }
}
