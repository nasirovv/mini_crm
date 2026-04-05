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

    public function getCustomersPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Customer::query()->withCount('tickets');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function getCustomerById(int $id): Customer
    {
        return Customer::query()->with('tickets')->withCount('tickets')->findOrFail($id);
    }
}
