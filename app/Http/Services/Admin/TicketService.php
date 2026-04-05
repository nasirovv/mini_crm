<?php

namespace App\Http\Services\Admin;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketService
{
    /**
     * @return static
     */
    public static function getInstance(): static
    {
        return new static();
    }

    public function getDashboardStats(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $monthTickets = Ticket::query()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get(['id', 'created_at']);

        $todayCount = $monthTickets->filter(fn($t) => $t->created_at->isToday())->count();
        $weekCount = $monthTickets->filter(fn($t) => $t->created_at->between($startOfWeek, $endOfWeek))->count();
        $monthCount = $monthTickets->count();
        $totalCount = Ticket::query()->count();
        $recentTickets = Ticket::with('customer')->latest()->take(10)->get();

        return compact('todayCount', 'weekCount', 'monthCount', 'totalCount', 'recentTickets');
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getTicketsPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Ticket::query()->with(['customer', 'answeredBy'])->latest()->paginate($perPage);
    }

    public function getTicketById(int $id): Ticket
    {
        return Ticket::query()->with(['customer', 'answeredBy'])->findOrFail($id);
    }
}
