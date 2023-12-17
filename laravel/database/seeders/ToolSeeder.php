<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tool;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = ['Hot stones', 'Towels and linens', 'Hairdryer', 'Hairbrushes and combs', 'Nail clippers and scissors'];

        foreach($tools as $tool){
            Tool::create([
                'name' => $tool
            ]);
        }
    }
}
