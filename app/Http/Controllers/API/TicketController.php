<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Services\API\CustomerService;
use App\Http\Services\API\TicketService;
use App\Models\Ticket;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

/**
 * Class TicketController
 * @package App\Http\Controllers\API
 */
class TicketController extends Controller
{
    public function store(StoreTicketRequest $request)
    {
        try {
            $data = $request->validated();

            $customerId = CustomerService::getInstance()->create($data);
            $ticket = TicketService::getInstance()->create($customerId, $data);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $ticket->addMedia($file)->toMediaCollection('tickets');
                }
            }

            return response()->json(['message' => 'Заявка успешно создана.'], 201);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
