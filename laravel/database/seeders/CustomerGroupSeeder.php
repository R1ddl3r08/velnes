<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerGroup;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerGroups = ['Blocked', 'Deleted', 'Best customers'];

        foreach($customerGroups as $customerGroup){
            CustomerGroup::create([
                'name' => $customerGroup
            ]);
        }
    }
}
