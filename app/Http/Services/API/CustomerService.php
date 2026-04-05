<?php

namespace App\Http\Services\API;

use App\Models\Customer;

class CustomerService
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static();
    }

    public function create(array $data)
    {
        $customer = Customer::query()->firstOrCreate(
            [
                'email' => $data['email'],
                'phone' => $data['phone'],
            ],
            [
                'name'  => $data['name'],
            ]
        );

        return $customer->id;
    }
}
