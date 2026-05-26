<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\TicketController;

class TicketControllerTest extends TestCase
{
    /**
     * UJI UNIT: Memastikan TicketController dapat diinstansiasi 
     * menggunakan Dummy Test Double (DummyTicketRepository).
     * 
     * Menurut konsep Testing:
     * Dummy adalah objek tiruan yang dioper ke constructor / method 
     * hanya untuk memenuhi parameter signature agar kode tidak error (compile/run).
     * Objek Dummy sama sekali TIDAK dipanggil method-nya dalam pengujian ini.
     */
    public function test_controller_can_be_instantiated_using_dummy(): void
    {
        // 1. Arrange: Siapkan objek Dummy (DummyTicketRepository)
        // Objek ini kosong dan tidak memiliki koneksi database.
        $dummyRepo = new DummyTicketRepository();

        // 2. Act: Instansiasi TicketController dengan menyuntikkan (inject) objek Dummy
        $controller = new TicketController($dummyRepo);

        // 3. Assert: Pastikan $controller berhasil dibuat dan merupakan instance dari TicketController
        $this->assertInstanceOf(TicketController::class, $controller);
    }
}
