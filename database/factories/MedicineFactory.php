<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    public function definition(): array
    {
        $manufacturers = \App\Models\Manufacturer::all()->pluck('id')->toArray();
        $categories = \App\Models\Medicine::CATEGORY;
        $units = \App\Models\Medicine::UNIT;
        $purchase_price = $this->faker->randomFloat(2, 2, 50);

        return [
            'manufacturer_id' => $this->faker->randomElement($manufacturers),
            'name' => $this->faker->unique()->word(),
            'generic_name' => $this->faker->word(),
            'strength' => $this->faker->numerify('### mg'),
            'category' => $this->faker->randomElement(array_keys($categories)),
            'unit' => $this->faker->randomElement(array_keys($units)),
            'purchase_price' => $purchase_price,
            'selling_price' => $purchase_price + 2,
            'discount' => 5.00,
            'is_active' => 1
        ];
    }
}
