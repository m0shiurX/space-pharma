<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseItemFactory extends Factory
{
    public function definition(): array
    {
        $medicines = \App\Models\Medicine::all()->pluck('id')->toArray();
        $quantity = $this->faker->randomDigitNot(0);
        $purchase = $this->faker->randomFloat(2, 5, 10);
        $selling = $purchase + 1.25;
        $total = $quantity * $purchase;

        return [
            'purchase_id' => $this->faker->randomDigitNotZero(),
            'medicine_id' => $this->faker->randomElement($medicines),
            'batch_id' => $this->faker->numerify('B22-####'),
            'expiry_date' => Carbon::today()->addYear(),
            'quantity' => $quantity,
            'purchase_price' => $purchase,
            'vat' => 0,
            'selling_price' => $selling,
            'total_price' => $total,
        ];
    }
}
