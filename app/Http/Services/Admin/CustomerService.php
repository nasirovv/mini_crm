<?php

namespace App\Http\Services\Admin;

use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static();
    }

    public function getCustomersPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Customer::query()->withCount('tickets')->latest()->paginate($perPage);
    }

    public function getCustomerById(int $id): Customer
    {
        return Customer::query()->with('tickets')->withCount('tickets')->findOrFail($id);
    }
}
