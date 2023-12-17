<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $userIds = DB::table('users')->pluck('id')->toArray();

        for($i=0; $i<20; $i++) {
            Employee::create([
                'user_id' => $faker->randomElement($userIds),
                'name' => $faker->name,
                'gender' => $faker->randomElement(['male', 'female', 'unknown']),
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'bookable_online' => $faker->boolean,
            ]);
        }
    }
}
