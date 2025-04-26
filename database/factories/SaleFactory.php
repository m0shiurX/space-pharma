<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;


class SaleFactory extends Factory
{
    public function definition(): array
    {
        $customers = \App\Models\Customer::all()->pluck('id')->toArray();

        return [
            'customer_id'       => $this->faker->randomElement($customers),
            'invoice_no'        => '',
            'sales_date'        => Carbon::today(),
            'sub_total'    => $this->faker->randomFloat(2, 15, 25),
            'invoice_discount'  => $this->faker->randomFloat(2, 10, 20),
            'vat'               => 0.00,
            'grand_total'       => $this->faker->randomFloat(2, 50, 200),
            'paid_amount'       => $this->faker->randomFloat(2, 50, 200),
            'exchange_amount'   => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}
