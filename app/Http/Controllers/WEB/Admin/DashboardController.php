<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\TicketService;

/**
 * Class DashboardController
 * @package App\Http\Controllers\WEB\Admin
 */
class DashboardController extends Controller
{
    public function index()
    {
        $stats = TicketService::getInstance()->getDashboardStats();

        return view('admin.dashboard', $stats);
    }
}
