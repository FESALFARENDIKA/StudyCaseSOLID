<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\TicketSearchRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    protected $ticketRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
    }
    
    // GET ALL (pagination, search, orderBy, sortBy)
    public function index(TicketSearchRequest $request)
    {
        $tickets = $this->ticketRepository->getAll(
            $request->validated()
        );

        return response()->json($tickets);
    }


    // GET ONE
    public function show($id)
    {
        $ticket = $this->ticketRepository->getById($id);

        return response()->json($ticket);
    }


    // CREATE
    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->ticketRepository->store(
            $request->validated()
        );

        return response()->json([
            "message" => "Ticket created",
            "data" => $ticket
        ]);
    }


    // UPDATE
    public function update(UpdateTicketRequest $request, $id)
    {
        $ticket = $this->ticketRepository->update(
            $id,
            $request->validated()
        );

        return response()->json([
            "message" => "Ticket updated",
            "data" => $ticket
        ]);
    }


    // DELETE
    public function destroy($id)
    {
        $this->ticketRepository->destroy($id);

        return response()->json([
            "message" => "Ticket deleted"
        ]);
    }
}
