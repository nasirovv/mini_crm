<?php

namespace App\Http\Services\API;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketService
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static();
    }

    /**
     * @param int   $customerId
     * @param array $data
     * @return Ticket|Model
     */
    public function create(int $customerId, array $data): Model|Ticket
    {
        return Ticket::query()->create([
            'customer_id' => $customerId,
            'topic'       => $data['topic'],
            'description' => $data['description'],
            'status'      => 'new',
        ]);
    }
}
