<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TicketRepositoryInterface;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    private TicketRepositoryInterface $tickets;

    public function __construct(TicketRepositoryInterface $tickets)
    {
        $this->tickets = $tickets;
    }

    // GET ALL
    public function index(Request $req)
    {
        $limit = $req->limit ?? 10;
        $search = $req->search ?? '';
        $orderBy = $req->orderBy ?? 'id';
        $sortBy = $req->sortBy ?? 'ASC';

        $tickets = $this->tickets->getAll(
            $limit,
            $search,
            $orderBy,
            $sortBy
        );

        return response()->json($tickets);
    }

    // GET ONE
    public function show($id)
    {
        return response()->json(
            $this->tickets->find($id)
        );
    }

    // CREATE
    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->tickets->create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Ticket created',
            'data' => $ticket,
        ]);
    }

    // UPDATE
    public function update(UpdateTicketRequest $request, $id)
    {
        $ticket = $this->tickets->update(
            $id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Ticket updated',
            'data' => $ticket,
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $this->tickets->delete($id);

        return response()->json([
            'message' => 'Ticket deleted'
        ]);
    }
}
