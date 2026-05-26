<?php

namespace Tests\Unit;

use App\Repositories\TicketRepositoryInterface;

/**
 * DUMMY TEST DOUBLE
 * 
 * Definisi: Dummy adalah objek tiruan yang dioper ke method atau constructor
 * hanya untuk memenuhi parameter signature agar kode bisa dikompilasi / dijalankan.
 * Objek Dummy ini sama sekali tidak pernah dipanggil method-nya di dalam pengujian ini.
 */
class DummyTicketRepository implements TicketRepositoryInterface
{
    public function getAll($search = '', $orderBy = 'id', $sortBy = 'ASC', $limit = 10)
    {
        // Tidak diimplementasikan karena Dummy tidak pernah dipanggil method-nya
        throw new \Exception("Method ini tidak boleh dipanggil karena ini adalah Dummy!");
    }

    public function findById($id)
    {
        throw new \Exception("Method ini tidak boleh dipanggil karena ini adalah Dummy!");
    }

    public function create(array $data)
    {
        throw new \Exception("Method ini tidak boleh dipanggil karena ini adalah Dummy!");
    }

    public function update($id, array $data)
    {
        throw new \Exception("Method ini tidak boleh dipanggil karena ini adalah Dummy!");
    }

    public function delete($id)
    {
        throw new \Exception("Method ini tidak boleh dipanggil karena ini adalah Dummy!");
    }
}
