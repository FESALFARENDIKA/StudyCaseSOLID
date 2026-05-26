<?php

namespace App\Interfaces;

interface TicketRepositoryInterface
{
    public function getAll(array $validated);

    public function getById($id);

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);
}
