<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function test_can_list_orders()
    {
        $user = User::factory()->create();
        Order::factory()->count(3)->create(['id_user' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/orders');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_can_create_order()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $client = Client::factory()->create();

        $orderData = [
            'id_client' => $client->id,
            'id_city' => $city->id,
            'id_user' => $user->id,
            'boarding_date' => '2025-04-20',
            'return_date' => '2025-04-25',
            'status' => 'confirmed'
        ];

        $response = $this->actingAs($user)->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                    'id',
                    'id_city',
                    'id_client',
                    'id_user',
                    'boarding_date',
                    'return_date',
                    'created_at',
                    'updated_at'
            ]);

        $this->assertDatabaseHas('orders', [
            'id_client' => $client->id,
            'id_city' => $city->id,
            'boarding_date' => '2025-04-20',
            'return_date' => '2025-04-25',
        ]);
    }

    public function test_can_get_order_by_id()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $client = Client::factory()->create();

        $order = Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city->id,
            'id_client' => $client->id
        ]);

        $response = $this->actingAs($user)->getJson("/api/v1/orders/{$order->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'city',
                    'client',
                    'seller',
                    'boarding_date',
                    'return_date',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJsonPath('data.id', $order->id);
    }

    public function test_can_update_order()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $newCity = City::factory()->create();
        $client = Client::factory()->create();

        $order = Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city->id,
            'id_client' => $client->id,
            'status' => 'pending'
        ]);

        $updateData = [
            'id_client' => $client->id,
            'id_city' => $newCity->id,
            'id_user' => $user->id,
            'boarding_date' => '2025-05-01',
            'return_date' => '2025-05-10',
            'status' => 'pending'
        ];

        $response = $this->actingAs($user)->putJson("/api/v1/orders/{$order->id}", $updateData);

        $response->assertOk()
            ->assertJson([
                'success' => [
                    'code' => 200,
                    'message' => config('api.order.update-success'),
                    'data' => []
                ]
            ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'id_city' => $newCity->id,
            'boarding_date' => '2025-05-01',
            'return_date' => '2025-05-10',
            'status' => 'pending'
        ]);
    }

    public function test_can_update_order_status()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $client = Client::factory()->create();

        $order = Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city->id,
            'id_client' => $client->id,
            'status' => 'pending'
        ]);

        $statusData = [
            'status' => 'confirmed'
        ];

        $response = $this->actingAs($user)
            ->putJson("/api/v1/orders/{$order->id}/update-status", $statusData);

        $response->assertOk()
            ->assertJsonPath('data.status', 'confirmed');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed'
        ]);
    }

    public function test_can_delete_order()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $client = Client::factory()->create();

        $order = Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city->id,
            'id_client' => $client->id
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/v1/orders/{$order->id}");

        $response->assertOk()
            ->assertJson([
                'success' => [
                    'code' => 200,
                    'message' => config('api.order.delete-success'),
                    'data' => []
                ]
            ]);

        $this->assertSoftDeleted('orders', [
            'id' => $order->id
        ]);
    }

    public function test_can_search_orders_by_city()
    {
        $user = User::factory()->create();
        $city1 = City::factory()->create(['name' => 'Porto Alegre']);
        $city2 = City::factory()->create(['name' => 'São Paulo']);
        $client = Client::factory()->create();

        Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city1->id,
            'id_client' => $client->id
        ]);

        Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city2->id,
            'id_client' => $client->id
        ]);

        $response = $this->actingAs($user)->getJson('/api/v1/orders/search?city=Porto');

        $response->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_can_search_orders_by_date_range()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();
        $client = Client::factory()->create();

        Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city->id,
            'id_client' => $client->id,
            'boarding_date' => '2025-04-14',
            'return_date' => '2025-04-20'
        ]);

        Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city->id,
            'id_client' => $client->id,
            'boarding_date' => '2025-04-25',
            'return_date' => '2025-04-30'
        ]);

        Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city->id,
            'id_client' => $client->id,
            'boarding_date' => '2026-04-26',
            'return_date' => '2026-04-30'
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/v1/orders/search?date_start=2025-04-14&date_end=2025-04-20');

        $response->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_validation_fails_with_invalid_data()
    {
        $user = User::factory()->create();

        $invalidData = [
            // Dados incompletos
            'boarding_date' => '2025-04-20',
            'return_date' => '2025-04-25',
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/v1/orders', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id_client', 'id_city', 'id_user']);
    }

    public function test_user_cannot_update_other_users_order_status()
    {
        $this->withExceptionHandling();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $city = City::factory()->create();
        $client = Client::factory()->create();

        $order = Order::factory()->create([
            'id_user' => $user1->id,
            'id_city' => $city->id,
            'id_client' => $client->id,
            'status' => 'pending'
        ]);

        $statusData = [
            'status' => 'confirmed'
        ];

        $response = $this->actingAs($user2)
            ->putJson("/api/v1/orders/{$order->id}/update-status", $statusData);

        $response->assertStatus(403);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'pending'
        ]);
    }
}
