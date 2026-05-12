<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketRepo;

    public function __construct(\App\Repositories\EloquentTicketRepository $ticketRepo)
    {
        $this->ticketRepo = $ticketRepo;
    }

    // GET ALL (pagination, search, orderBy, sortBy)
    public function index(Request $req)
    {
        $limit = $req->limit ?? 10;
        $search = $req->search ?? '';
        $orderBy = $req->orderBy ?? 'id';
        $sortBy = $req->sortBy ?? 'ASC';

        $tickets = $this->ticketRepo->getAll($search, $orderBy, $sortBy, $limit);

        return response()->json($tickets);
    }


    // GET ONE
    public function show($id)
    {
        $ticket = $this->ticketRepo->findById($id);
        return response()->json($ticket);
    }


    // CREATE
    public function store(Request $req)
    {
        $ticket = $this->ticketRepo->create($req->all());
        return response()->json([
            "message" => "Ticket created",
            "data" => $ticket
        ], 201);
    }


    // UPDATE
    public function update(Request $req, $id)
    {
        $ticket = $this->ticketRepo->update($id, $req->all());

        return response()->json([
            "message" => "Ticket updated",
            "data" => $ticket
        ]);
    }


    // DELETE
    public function destroy($id)
    {
        $this->ticketRepo->delete($id);
        return response()->json(["message" => "Ticket deleted"]);
    }
}
