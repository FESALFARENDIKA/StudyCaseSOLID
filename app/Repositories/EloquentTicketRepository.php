<?php

namespace App\Repositories;

use App\Models\Ticket;

class EloquentTicketRepository implements TicketRepositoryInterface
{
    public function search(array $filters)
    {
        $query = Ticket::query();

        if (!empty($filters['search'])) {
            $query->where('movie_title', 'LIKE', "%{$filters['search']}%");
        }

        if (!empty($filters['orderBy'])) {
            $query->orderBy($filters['orderBy'], $filters['sortBy'] ?? 'ASC');
        }

        return $query->paginate($filters['limit'] ?? 10);
    }

    public function find(int $id)
    {
        return Ticket::findOrFail($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update(int $id, array $data)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return $ticket;
    }

    public function delete(int $id): bool
    {
        return (bool) Ticket::destroy($id);
    }
}
