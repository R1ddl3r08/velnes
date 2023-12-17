<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $serviceIds = DB::table('services')->pluck('id')->toArray();
        $customerIds = DB::table('customers')->pluck('id')->toArray();
        $employeeIds = DB::table('employees')->pluck('id')->toArray();
        $toolIds = DB::table('tools')->pluck('id')->toArray();
        $roomIds = DB::table('rooms')->pluck('id')->toArray();

        $startDateTime = now()->startOfDay()->setHour(9)->setMinute(0);
        $endDateTime = now()->startOfDay()->setHour(15)->setMinute(0);

        for ($i = 0; $i < 3; $i++) {
            $randomDateTime = $faker->dateTimeBetween($startDateTime, $endDateTime);
            $roundedDateTime = $randomDateTime->setTime($randomDateTime->format('H'), ceil($randomDateTime->format('i') / 15) * 15, 0);

            Appointment::create([
                'service_id' => $faker->randomElement($serviceIds),
                'employee_id' => $faker->randomElement($employeeIds),
                'customer_id' => $faker->randomElement($customerIds),
                'tool_1_id' => $faker->randomElement($toolIds),
                'tool_2_id' => $faker->optional()->randomElement($toolIds),
                'room_id' => $faker->randomElement($roomIds),
                'duration' => $faker->randomElement([15, 30, 45, 60, 75, 90]),
                'date_time' => $roundedDateTime->format('Y-m-d H:i:s'),
            ]);
        }

        for ($i = 0; $i < 20; $i++) {
            $randomDateTime = $faker->dateTimeBetween('now', '+30 days');
            $roundedDateTime = $randomDateTime->setTime($randomDateTime->format('H'), ceil($randomDateTime->format('i') / 15) * 15, 0); // Round to the nearest 15 minutes

            Appointment::create([
                'service_id' => $faker->randomElement($serviceIds),
                'employee_id' => $faker->randomElement($employeeIds),
                'customer_id' => $faker->randomElement($customerIds),
                'tool_1_id' => $faker->randomElement($toolIds),
                'tool_2_id' => $faker->optional()->randomElement($toolIds),
                'room_id' => $faker->randomElement($roomIds),
                'duration' => $faker->randomElement([15, 30, 45, 60, 75, 90]),
                'date_time' => $roundedDateTime->format('Y-m-d H:i:s'),
            ]);
        }
    }

}
