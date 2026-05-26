<?php

namespace App\Repositories;

use App\Interfaces\TicketRepositoryInterface;
use App\Models\Ticket;

class TicketRepository implements TicketRepositoryInterface
{
    public function getAll(array $validated)
    {
        $limit = $validated['limit'] ?? 10;
        $search = $validated['search'] ?? '';
        $orderBy = $validated['orderBy'] ?? 'id';
        $sortBy = $validated['sortBy'] ?? 'ASC';

        return Ticket::where('movie_title', 'LIKE', "%{$search}%")
            ->orderBy($orderBy, $sortBy)
            ->paginate($limit);
    }

    public function getById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function store(array $data)
    {
        return Ticket::create($data);
    }

    public function update($id, array $data)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->update($data);

        return $ticket;
    }

    public function destroy($id)
    {
        return Ticket::destroy($id);
    }
}
