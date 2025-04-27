<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->generateRandomName(),
            'email' => $this->generateRandomEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Generate a random name.
     */
    private function generateRandomName(): string
    {
        $firstNames = ['John', 'Jane', 'Alex', 'Emily', 'Chris', 'Katie'];
        $lastNames = ['Smith', 'Doe', 'Johnson', 'Brown', 'Davis', 'Miller'];

        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    /**
     * Generate a random email.
     */
    private function generateRandomEmail(): string
    {
        $domains = ['example.com', 'test.com', 'demo.com'];
        $username = Str::random(8);

        return $username . '@' . $domains[array_rand($domains)];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
