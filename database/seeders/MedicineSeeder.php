<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\Medicine::factory(20)->create();
        \App\Models\Medicine::factory(50)->hasStocks(2)->create();
    }
}
