<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'booking_id' => 1,
                'amount' => 30000,
                'status' => 'pending',
                'snap_token' => 'snap_token_1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'booking_id' => 2,
                'amount' => 40000,
                'status' => 'success',
                'snap_token' => 'snap_token_1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
