<?php

namespace App\Repositories;

interface TicketRepositoryInterface
{
    public function getAll($search = '', $orderBy = 'id', $sortBy = 'ASC', $limit = 10);

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
