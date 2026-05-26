<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_paginated_tickets()
    {
        Ticket::factory()->count(15)->create();

        $response = $this->getJson('/api/tickets?limit=5');

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_index_can_search_by_movie_title()
    {
        Ticket::factory()->create(['movie_title' => 'Avengers']);
        Ticket::factory()->create(['movie_title' => 'Batman']);

        $response = $this->getJson('/api/tickets?search=Avengers');

        $response->assertStatus(200);
        $response->assertJsonFragment(['movie_title' => 'Avengers']);
        $response->assertJsonMissing(['movie_title' => 'Batman']);
    }

    public function test_show_returns_single_ticket()
    {
        $ticket = Ticket::factory()->create([
            'movie_title' => 'Interstellar'
        ]);

        $response = $this->getJson("/api/tickets/{$ticket->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('movie_title', 'Interstellar');
    }

    public function test_store_saves_new_ticket_to_db()
    {
        $payload = [
            'movie_title' => 'Inception',
            'price' => 45000,
            'seat_number' => 'D12'
        ];

        $response = $this->postJson('/api/tickets', $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Ticket created']);

        $this->assertDatabaseHas('tickets', [
            'movie_title' => 'Inception',
            'seat_number' => 'D12'
        ]);
    }

    public function test_update_modifies_existing_ticket()
    {
        $ticket = Ticket::factory()->create(['movie_title' => 'Old Title']);

        $payload = ['movie_title' => 'New Title'];

        $response = $this->putJson("/api/tickets/{$ticket->id}", $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'movie_title' => 'New Title'
        ]);
    }

    public function test_destroy_deletes_ticket_correctly()
    {
        $ticket = Ticket::factory()->create();

        $response = $this->deleteJson("/api/tickets/{$ticket->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Ticket deleted']);

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
