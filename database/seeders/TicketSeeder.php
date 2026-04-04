<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $users = User::all();

        $customers->each(function ($customer) use ($users) {
            Ticket::factory(rand(1, 2))->create([
                'customer_id' => $customer->id,
            ]);

            Ticket::factory(rand(0, 1))->create([
                'customer_id' => $customer->id,
                'answered_by' => $users->random()->id,
                'status'      => 'done',
            ]);
        });
    }
}
