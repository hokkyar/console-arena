<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookings')->insert([
          [
              'service_id' => 1,
              'booking_date' => now()->addDays(2)->toDateString(),
              'session' => 'Sesi 1',
              'customer_name' => 'John Doe',
              'customer_phone' => '081234567890',
              'customer_email' => 'T8i0M@example.com',
              'status' => 'pending',
              'created_at' => now(),
              'updated_at' => now(),
          ],
          [
              'service_id' => 2,
              'booking_date' => now()->addDays(5)->toDateString(),
              'session' => 'Sesi 2',
              'customer_name' => 'Jane Doe',
              'customer_phone' => '082345678901',
              'customer_email' => 'fzL2K@example.com',
              'status' => 'paid',
              'created_at' => now(),
              'updated_at' => now(),
          ],
      ]);
    }
}
