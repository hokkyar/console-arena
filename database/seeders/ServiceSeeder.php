<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'name' => 'Rental PS 4',
                'price' => 30000,
                'description' => 'Nikmati pengalaman gaming seru dengan PlayStation 4, konsol yang menghadirkan berbagai game eksklusif seperti God of War, The Last of Us, dan Spider-Man. Dengan grafis yang tajam dan gameplay yang responsif, PS4 tetap menjadi pilihan utama bagi para gamer. Layanan rental kami menyediakan unit berkualitas dengan berbagai pilihan game terbaru yang dapat dimainkan bersama teman atau keluarga. Jadikan waktu luangmu lebih menyenangkan dengan bermain di layar lebar dan suara yang jernih.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rental PS 5',
                'price' => 40000,
                'description' => 'Rasakan pengalaman gaming terbaik dengan PlayStation 5, konsol generasi terbaru yang menghadirkan grafis ultra-realistis dan kecepatan loading super cepat. Dengan dukungan teknologi ray tracing dan resolusi 4K, game seperti Demon’s Souls, Ratchet & Clank: Rift Apart, dan Horizon Forbidden West tampil lebih hidup dari sebelumnya. Sistem rental kami memastikan bahwa Anda mendapatkan pengalaman gaming terbaik tanpa harus membeli konsol sendiri. Sempurna untuk sesi game solo maupun bermain bersama teman.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
