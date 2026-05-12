<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TicketRepositoryInterface;

class TicketController extends Controller
{
    public function __construct(private TicketRepositoryInterface $ticketRepository)
    {
    }

    // GET ALL (pagination, search, orderBy, sortBy)
    public function index(Request $req)
    {
        $tickets = $this->ticketRepository->search($req->query());

        return response()->json($tickets);
    }


    // GET ONE
    public function show($id)
    {
        $ticket = $this->ticketRepository->find($id);
        return response()->json($ticket);
    }


    // CREATE
    public function store(Request $req)
    {
        $ticket = $this->ticketRepository->create($req->all());
        return response()->json([
            "message" => "Ticket created",
            "data" => $ticket
        ]);
    }


    // UPDATE
    public function update(Request $req, $id)
    {
        $ticket = $this->ticketRepository->update($id, $req->all());

        return response()->json([
            "message" => "Ticket updated",
            "data" => $ticket
        ]);
    }


    // DELETE
    public function destroy($id)
    {
        $this->ticketRepository->delete($id);
        return response()->json(["message" => "Ticket deleted"]);
    }
}
