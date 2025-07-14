<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\FaqRespuestasSeeder;
use Database\Seeders\AnalysisTableSeeder;
use Database\Seeders\IATableSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        $this->call([
            FaqRespuestasSeeder::class,
            AnalysisTableSeeder::class,
            IATableSeeder::class,

        ]);
    }
}
