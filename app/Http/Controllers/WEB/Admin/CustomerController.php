<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\CustomerService;

/**
 * Class CustomerController
 * @package App\Http\Controllers\WEB\Admin
 */
class CustomerController extends Controller
{
    public function index()
    {
        $customers = CustomerService::getInstance()->getCustomersPaginated();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(int $customer)
    {
        $customer = CustomerService::getInstance()->getCustomerById($customer);

        return view('admin.customers.show', compact('customer'));
    }
}
