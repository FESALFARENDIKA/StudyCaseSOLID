<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\TicketSearchRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    // GET ALL (pagination, search, orderBy, sortBy)
    public function index(TicketSearchRequest $request)
    {
        $validated = $request->validated();
        
        $limit = $validated['limit'] ?? 10;
        $search = $validated['search'] ?? '';
        $orderBy = $validated['orderBy'] ?? 'id';
        $sortBy = $validated['sortBy'] ?? 'ASC';

        $tickets = Ticket::where('movie_title', 'LIKE', "%{$search}%")
            ->orderBy($orderBy, $sortBy)
            ->paginate($limit);

        return response()->json($tickets);
    }


    // GET ONE
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return response()->json($ticket);
    }


    // CREATE
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());
        return response()->json([
            "message" => "Ticket created",
            "data" => $ticket
        ]);
    }


    // UPDATE
    public function update(UpdateTicketRequest $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->validated());

        return response()->json([
            "message" => "Ticket updated",
            "data" => $ticket
        ]);
    }


    // DELETE
    public function destroy($id)
    {
        Ticket::destroy($id);
        return response()->json(["message" => "Ticket deleted"]);
    }
}
