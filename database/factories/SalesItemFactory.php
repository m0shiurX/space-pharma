<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesItemFactory extends Factory
{
    public function definition(): array
    {
        $medicines = \App\Models\Medicine::all()->pluck('id')->toArray();
        $quantity = $this->faker->randomDigitNot(0);
        $unit_price = $this->faker->randomFloat(2, 5, 10);
        $discount = $this->faker->randomDigitNot(0);

        return [
            'sale_id'       => 1,
            'medicine_id'   => $this->faker->randomElement($medicines),
            'batch_id'      => $this->faker->numerify('B22-####'),
            'quantity'      => $quantity,
            'selling_price' => $unit_price,
            'discount'      => $discount,
            'total_price'   => number_format((($discount / ($quantity * $unit_price)) * 100), 2)
        ];
    }
}
