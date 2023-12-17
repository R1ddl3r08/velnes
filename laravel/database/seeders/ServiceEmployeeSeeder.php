<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Employee;
use App\Models\Service;

class ServiceEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $employeeIds = Employee::pluck('id')->all();
        $serviceIds = Service::pluck('id')->all();

        foreach (range(1, 20) as $index) {
            DB::table('services_employees')->insert([
                'employee_id' => $faker->randomElement($employeeIds),
                'service_id' => $faker->randomElement($serviceIds),
            ]);
        }
    }
}
