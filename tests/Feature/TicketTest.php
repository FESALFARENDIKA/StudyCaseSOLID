<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use App\Interfaces\TicketRepositoryInterface;

class TicketTest extends TestCase
{
    public function test_get_all_tickets()
    {
        $mock = Mockery::mock(TicketRepositoryInterface::class);

        $mock->shouldReceive('getAll')
            ->once()
            ->andReturn([
                [
                    'id' => 1,
                    'movie_title' => 'Avengers'
                ]
            ]);

        $this->app->instance(
            TicketRepositoryInterface::class,
            $mock
        );

        $response = $this->getJson('/api/tickets');

        $response->assertStatus(200);
    }
}
