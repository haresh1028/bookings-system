<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $chunks = 10000;

        for ($i = 0; $i < 100; $i++) {
            $data = [];

            for ($j = 0; $j < $chunks; $j++) {
                $type = $faker->randomElement(['full_day', 'half_day', 'custom']);
                $slot = $type === 'half_day' ? $faker->randomElement(['first_half', 'second_half']) : null;
                $from = $type === 'custom' ? $faker->time('H:i') : null;
                $to = $type === 'custom' ? date('H:i', strtotime($from . ' +2 hours')) : null;

                $data[] = [
                    'user_id' => 1,
                    'customer_name' => $faker->name,
                    'customer_email' => $faker->unique()->safeEmail,
                    'booking_date' => $faker->dateTimeBetween('-1 years', '+1 years')->format('Y-m-d'),
                    'booking_type' => $type,
                    'booking_slot' => $slot,
                    'from_time' => $from,
                    'to_time' => $to,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('bookings')->insert($data);
        }
    }
}
