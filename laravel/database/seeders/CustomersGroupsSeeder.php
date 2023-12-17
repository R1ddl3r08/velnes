<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomersGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        $customerIds = Customer::pluck('id')->all();
        $customerGroupIds = CustomerGroup::pluck('id')->all();

        foreach (range(1, 10) as $index) {
            DB::table('customers_groups')->insert([
                'customer_id' => $faker->randomElement($customerIds),
                'customer_group_id' => $faker->randomElement($customerGroupIds),
            ]);
        }
    }
    
}
