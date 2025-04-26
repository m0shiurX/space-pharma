<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    public function definition(): array
    {
        $manufacturers = \App\Models\Manufacturer::all()->pluck('id')->toArray();
        $latest_invoice = \App\Models\Purchase::withTrashed()->latest()->max('id') + 1;

        return [
            'manufacturer_id'   => $this->faker->randomElement($manufacturers),
            'invoice_no'        => 'PR-' . str_pad((int) $latest_invoice, 6, '0', STR_PAD_LEFT),
            'purchase_date'     => Carbon::today(),
            'sub_total'         => $this->faker->randomFloat(2, 50, 200),
            'vat'               => $this->faker->randomFloat(2, 50, 200),
            'discount'          => $this->faker->randomFloat(2, 10, 20),
            'vat_total'       => $this->faker->randomFloat(2, 50, 200),
            'grand_total'       => $this->faker->randomFloat(2, 50, 200),
            'paid_amount'       => $this->faker->randomFloat(2, 50, 200),
            'due_amount'        => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}
