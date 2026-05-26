<?php

namespace Tests\Unit;

use App\Http\Controllers\TicketController;
use App\Repositories\TicketRepositoryInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_show_returns_ticket_json_from_repository(): void
    {
        $ticketId = 27;

        $expectedTicket = [
            'id' => $ticketId,
            'movie_title' => 'Malam Festival di Cinema Plaza',
            'cinema_name' => 'Studio 4 - CineCity',
            'seat' => 'B12',
            'showtime' => '2026-06-15 20:30:00',
            'price' => 115000,
            'status' => 'confirmed',
            'viewer_name' => 'Putri Anggraini',
            'created_at' => '2026-05-20 14:10:00',
        ];

        $ticketRepository = Mockery::mock(TicketRepositoryInterface::class);
        $ticketRepository
            ->shouldReceive('find')
            ->once()
            ->with($ticketId)
            ->andReturn($expectedTicket);

        $controller = new TicketController($ticketRepository);
        $response = $controller->show($ticketId);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($expectedTicket, $response->getData(true));
    }
}
