<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\TicketService;

/**
 * Class TicketController
 * @package App\Http\Controllers\WEB\Admin
 */
class TicketController extends Controller
{
    public function index()
    {
        $tickets = TicketService::getInstance()->getTicketsPaginated();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(int $ticket)
    {
        $ticket = TicketService::getInstance()->getTicketById($ticket);

        return view('admin.tickets.show', compact('ticket'));
    }
}
