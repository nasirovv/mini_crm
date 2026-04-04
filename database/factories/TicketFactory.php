<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'topic' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['new', 'on_process', 'done']),
            'answered_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'answered_by' => null,
        ];
    }
}
