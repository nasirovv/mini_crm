<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\CustomerService;
use Illuminate\Http\Request;

/**
 * Class CustomerController
 * @package App\Http\Controllers\WEB\Admin
 */
class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search']);
        $customers = CustomerService::getInstance()->getCustomersPaginated($filters);

        return view('admin.customers.index', compact('customers', 'filters'));
    }

    public function show(int $customer)
    {
        $customer = CustomerService::getInstance()->getCustomerById($customer);

        return view('admin.customers.show', compact('customer'));
    }
}
