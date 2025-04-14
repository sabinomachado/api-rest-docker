<?php

namespace Tests\Feature;

use App\Enum\OrderStatusEnum;
use App\Models\City;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_orders()
    {
        $user = User::factory()->create();
        Order::factory()->count(3)->create(['id_user' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/orders');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }


}
