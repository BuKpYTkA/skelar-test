<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(),
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(),
            'category_id' => $this->faker->boolean ? Category::factory()->create()->getKey() : null,
            'created_by' => User::factory()->create()->getKey()
        ];
    }
}
