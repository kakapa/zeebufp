<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => 'PKG' . $this->faker->unique()->numberBetween(1, 999),
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'contribution' => $this->faker->randomFloat(2, 10, 200),
            'coverage' => $this->faker->randomFloat(2, 1000, 20000),
            'features' => implode(', ', $this->faker->words($nb = 5, $asText = false)),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'main' => $this->faker->boolean(60), // 60% chance to be the main package
        ];
    }
}