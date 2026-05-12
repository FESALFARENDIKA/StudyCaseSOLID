<?php

namespace App\Repositories;

use App\Models\Ticket;

class EloquentTicketRepository
{
    public function getAll($search = '', $orderBy = 'id', $sortBy = 'ASC', $limit = 10)
    {
        return Ticket::where('movie_title', 'LIKE', "%$search%")
            ->orderBy($orderBy, $sortBy)
            ->paginate($limit);
    }

    public function findById($id)
    {
        return Ticket::findOrFail($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update($id, array $data)
    {
        $ticket = $this->findById($id);
        $ticket->update($data);
        return $ticket;
    }

    public function delete($id)
    {
        return Ticket::destroy($id);
    }
}
