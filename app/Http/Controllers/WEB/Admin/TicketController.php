<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\TicketService;
use Illuminate\Http\Request;

/**
 * Class TicketController
 * @package App\Http\Controllers\WEB\Admin
 */
class TicketController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['email', 'phone', 'status', 'date_from', 'date_to']);
        $tickets = TicketService::getInstance()->getTicketsPaginated($filters);

        return view('admin.tickets.index', compact('tickets', 'filters'));
    }

    public function show(int $ticket)
    {
        $ticket = TicketService::getInstance()->getTicketById($ticket);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, int $ticket)
    {
        $request->validate([
            'status' => 'required|in:new,on_process,done',
        ]);

        TicketService::getInstance()->updateStatus($ticket, $request->input('status'), auth()->id());

        return back()->with('success', 'Статус обновлён');
    }
}
