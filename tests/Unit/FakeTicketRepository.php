<?php

namespace Tests\Unit;

use App\Repositories\TicketRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FakeTicketRepository implements TicketRepositoryInterface
{
    private array $tickets = [];
    private int $counter = 0;

    public function getAll($search = '', $orderBy = 'id', $sortBy = 'ASC', $limit = 10)
    {
        $filtered = $this->tickets;

        if (!empty($search)) {
            $filtered = array_filter($filtered, function ($ticket) use ($search) {
                return stripos($ticket['movie_title'] ?? '', $search) !== false;
            });
        }

        // Sorting
        usort($filtered, function ($a, $b) use ($orderBy, $sortBy) {
            $valA = $a[$orderBy] ?? '';
            $valB = $b[$orderBy] ?? '';
            if ($sortBy === 'DESC') {
                return $valB <=> $valA;
            }
            return $valA <=> $valB;
        });

        // Simulasikan struktur hasil paginasi Laravel
        return [
            'data' => array_values(array_slice($filtered, 0, $limit)),
            'total' => count($filtered),
            'per_page' => $limit,
            'current_page' => 1
        ];
    }

    public function findById($id)
    {
        foreach ($this->tickets as $ticket) {
            if ($ticket['id'] == $id) {
                return (object) $ticket;
            }
        }
        throw new ModelNotFoundException("Ticket with ID $id not found");
    }

    public function create(array $data)
    {
        $this->counter++;
        $ticket = array_merge(['id' => $this->counter], $data);
        $this->tickets[] = $ticket;
        return (object) $ticket;
    }

    public function update($id, array $data)
    {
        foreach ($this->tickets as $key => $ticket) {
            if ($ticket['id'] == $id) {
                $updatedTicket = array_merge($ticket, $data);
                $this->tickets[$key] = $updatedTicket;
                return (object) $updatedTicket;
            }
        }
        throw new ModelNotFoundException("Ticket with ID $id not found");
    }

    public function delete($id)
    {
        foreach ($this->tickets as $key => $ticket) {
            if ($ticket['id'] == $id) {
                unset($this->tickets[$key]);
                $this->tickets = array_values($this->tickets);
                return true;
            }
        }
        return false;
    }
}
