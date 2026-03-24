<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    public function run()
    {
        $kapasitas = [6, 8, 10, 12, 14, 16, 18, 6, 8, 10];

        for ($i = 1; $i <= 10; $i++) {
            Meja::create([
                'no_meja' => $i,
                'kapasitas' => $kapasitas[$i - 1],
                'status' => 'tersedia'
            ]);
        }
    }
}