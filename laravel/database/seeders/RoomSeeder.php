<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = ['Massage Room', 'Hair Styling Studio', 'Manicure and Pedicure Area', 'Facial and Skincare Room', 'Makeup Studio'];

        foreach($rooms as $room){
            Room::create([
                'name' => $room
            ]);
        }
    }
}
