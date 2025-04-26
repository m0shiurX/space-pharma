<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{

    public function definition(): array
    {
        $medicines = \App\Models\Medicine::all()->pluck('id')->toArray();
        $quantity = $this->faker->randomDigitNot(0);

        return [
            'medicine_id' => $this->faker->randomElement($medicines),
            'batch_id' => $this->faker->numerify('B22-####'),
            'expiry_date' => Carbon::today()->addYear(),
            'stock' => $quantity,
        ];
    }
}
