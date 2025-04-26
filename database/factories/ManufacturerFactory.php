<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ManufacturerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'location' => $this->faker->city(),
            'contact_name' => $this->faker->name(),
            'contact_tel' => $this->faker->unique()->phoneNumber(),
        ];
    }
}
