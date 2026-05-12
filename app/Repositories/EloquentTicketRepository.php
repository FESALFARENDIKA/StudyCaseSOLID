<?php

namespace App\Repositories;

use App\Models\Ticket;

class EloquentTicketRepository implements TicketRepositoryInterface
{
    public function getAll($limit, $search, $orderBy, $sortBy)
    {
        return Ticket::where('movie_title', 'LIKE', "%$search%")
            ->orderBy($orderBy, $sortBy)
            ->paginate($limit);
    }

    public function find($id)
    {
        return Ticket::findOrFail($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update($id, array $data)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return $ticket;
    }

    public function delete($id)
    {
        return Ticket::destroy($id);
    }
}
