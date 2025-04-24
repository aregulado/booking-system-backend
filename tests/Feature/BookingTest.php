<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_booking()
    {
        // Create a user with Sanctum token
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // Create a room
        $room = Room::create([
            'number' => 'R001',
            'type' => 'Standard',
            'is_available' => true,
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/bookings', [
                'guest_name' => 'John Doe',
                'room_id' => $room->id,
                'check_in_date' => now()->addDays(1)->format('Y-m-d'),
                'check_out_date' => now()->addDays(3)->format('Y-m-d'),
                'promo_code' => 'SUMMER2025',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'booking' => [
                    'id',
                    'guest_name',
                    'room_id',
                    'check_in_date',
                    'check_out_date',
                    'status',
                    'promo_code',
                ],
            ]);
    }
}
