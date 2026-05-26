<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\TicketController;
use App\Repositories\TicketRepositoryInterface;
use Illuminate\Http\Request;
use Mockery;

class TicketControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * ==========================================
     * 1. PENGUJIAN MENGGUNAKAN STUB & MOCK
     * ==========================================
     */

    public function test_index_returns_all_tickets_using_stub(): void
    {
        // Setup: Membuat Stub untuk TicketRepositoryInterface
        $stubRepo = $this->createMock(TicketRepositoryInterface::class);

        // Menentukan data dummy yang dikembalikan oleh Stub
        $dummyTickets = [
            'data' => [
                ['id' => 1, 'movie_title' => 'Avengers', 'price' => 50000],
                ['id' => 2, 'movie_title' => 'Spiderman', 'price' => 45000]
            ],
            'total' => 2
        ];

        // Konfigurasi Stub: getAll() harus mengembalikan $dummyTickets
        $stubRepo->method('getAll')
            ->willReturn($dummyTickets);

        // Inject Stub ke Controller
        $controller = new TicketController($stubRepo);

        // Execute: Panggil method index()
        $request = Request::create('/tickets', 'GET', [
            'limit' => 10,
            'search' => '',
            'orderBy' => 'id',
            'sortBy' => 'ASC'
        ]);
        $response = $controller->index($request);

        // Assert: Pastikan output sesuai dengan data dummy dari Stub
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals($dummyTickets, $responseData);
    }

    public function test_show_returns_single_ticket_using_stub(): void
    {
        // Setup: Membuat Stub
        $stubRepo = $this->createMock(TicketRepositoryInterface::class);

        $dummyTicket = (object) [
            'id' => 1,
            'movie_title' => 'Avengers',
            'studio' => 'Studio 1',
            'seat' => 'A1',
            'show_time' => '2026-05-26 19:00:00',
            'price' => 50000,
            'user_name' => 'Fesal'
        ];

        // Konfigurasi Stub: findById(1) mengembalikan $dummyTicket
        $stubRepo->method('findById')
            ->with(1)
            ->willReturn($dummyTicket);

        // Inject
        $controller = new TicketController($stubRepo);

        // Execute
        $response = $controller->show(1);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Avengers', $responseData['movie_title']);
        $this->assertEquals('Fesal', $responseData['user_name']);
    }

    public function test_store_creates_ticket_successfully_using_stub(): void
    {
        // Setup: Membuat Stub
        $stubRepo = $this->createMock(TicketRepositoryInterface::class);

        $inputData = [
            'movie_title' => 'Inception',
            'studio' => 'Studio 2',
            'seat' => 'B5',
            'show_time' => '2026-05-26 21:00:00',
            'price' => 60000,
            'user_name' => 'Arendika'
        ];

        $createdTicket = (object) array_merge(['id' => 10], $inputData);

        // Konfigurasi Stub: create() mengembalikan object tiket yang berhasil dibuat
        $stubRepo->method('create')
            ->with($inputData)
            ->willReturn($createdTicket);

        // Inject
        $controller = new TicketController($stubRepo);

        // Execute
        $request = Request::create('/tickets', 'POST', $inputData);
        $response = $controller->store($request);

        // Assert
        $this->assertEquals(201, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Ticket created', $responseData['message']);
        $this->assertEquals('Inception', $responseData['data']['movie_title']);
        $this->assertEquals(10, $responseData['data']['id']);
    }

    public function test_update_modifies_ticket_successfully_using_stub(): void
    {
        // Setup: Membuat Stub
        $stubRepo = $this->createMock(TicketRepositoryInterface::class);

        $updateData = ['price' => 55000];
        $updatedTicket = (object) [
            'id' => 1,
            'movie_title' => 'Avengers',
            'price' => 55000
        ];

        // Konfigurasi Stub: update(1, $updateData) mengembalikan $updatedTicket
        $stubRepo->method('update')
            ->with(1, $updateData)
            ->willReturn($updatedTicket);

        // Inject
        $controller = new TicketController($stubRepo);

        // Execute
        $request = Request::create('/tickets/1', 'PUT', $updateData);
        $response = $controller->update($request, 1);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Ticket updated', $responseData['message']);
        $this->assertEquals(55000, $responseData['data']['price']);
    }

    public function test_destroy_deletes_ticket_successfully_using_mock(): void
    {
        // Setup: Membuat MOCK untuk memverifikasi interaksi
        $mockRepo = $this->createMock(TicketRepositoryInterface::class);

        // Ekspektasi Mock: method delete(5) HARUS dipanggil tepat 1 kali
        $mockRepo->expects($this->once())
            ->method('delete')
            ->with(5);

        // Inject
        $controller = new TicketController($mockRepo);

        // Execute
        $response = $controller->destroy(5);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Ticket deleted', $responseData['message']);
    }

    /**
     * ==========================================
     * 2. PENGUJIAN MENGGUNAKAN FAKE (IN-MEMORY)
     * ==========================================
     */

    public function test_controller_integration_using_fake_repository(): void
    {
        // Setup: Menggunakan FAKE repository buatan sendiri yang menyimpan data di memori
        $fakeRepo = new FakeTicketRepository();

        // Tambahkan beberapa data awal langsung melalui Fake Repository
        $fakeRepo->create([
            'movie_title' => 'Batman Begins',
            'studio' => 'Studio 1',
            'seat' => 'C1',
            'show_time' => '2026-05-26 15:00:00',
            'price' => 50000,
            'user_name' => 'Julio'
        ]);

        $fakeRepo->create([
            'movie_title' => 'The Dark Knight',
            'studio' => 'Studio 1',
            'seat' => 'C2',
            'show_time' => '2026-05-26 18:00:00',
            'price' => 55000,
            'user_name' => 'Ferdian'
        ]);

        // Inject Fake Repository ke Controller
        $controller = new TicketController($fakeRepo);

        // 1. Uji fungsi GET ALL dengan pencarian kata kunci "Dark"
        $requestIndex = Request::create('/tickets', 'GET', [
            'search' => 'Dark',
            'limit' => 10,
            'orderBy' => 'id',
            'sortBy' => 'ASC'
        ]);
        $responseIndex = $controller->index($requestIndex);
        
        $dataIndex = json_decode($responseIndex->getContent(), true);
        
        // Assert: Hanya "The Dark Knight" yang harus ditemukan (total = 1)
        $this->assertEquals(1, $dataIndex['total']);
        $this->assertEquals('The Dark Knight', $dataIndex['data'][0]['movie_title']);

        // 2. Uji fungsi UPDATE harga untuk tiket Batman Begins (ID = 1)
        $requestUpdate = Request::create('/tickets/1', 'PUT', [
            'price' => 75000
        ]);
        $responseUpdate = $controller->update($requestUpdate, 1);
        
        $dataUpdate = json_decode($responseUpdate->getContent(), true);
        $this->assertEquals(75000, $dataUpdate['data']['price']);

        // Pastikan perubahan benar-benar tersimpan di dalam Fake Repository
        $savedTicket = $fakeRepo->findById(1);
        $this->assertEquals(75000, $savedTicket->price);
    }
}
