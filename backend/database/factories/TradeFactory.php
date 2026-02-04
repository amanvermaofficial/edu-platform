<?php

namespace Database\Factories;

use App\Models\Trade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trade>
 */
class TradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Trade::class;
    public function definition(): array
    {
        return [
            'name'        => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(10),
            'is_active'   => true,
        ];
    }
}
