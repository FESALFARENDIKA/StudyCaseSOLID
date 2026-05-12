<?php

namespace App\Repositories;

interface TicketRepositoryInterface
{
    public function getAll($limit, $search, $orderBy, $sortBy);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
