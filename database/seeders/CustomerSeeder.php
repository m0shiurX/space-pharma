<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Customer::factory(1)->create([
            'name' => 'A walk-in customer',
            'address' => 'Bogura, Bangladesh',
            'phone' => '0',
        ]);
    }
}
