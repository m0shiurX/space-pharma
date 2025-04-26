<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Stock::factory(20)->create();
    }
}
