<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Repositories\Order\EloquentOrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_status_updates_the_order()
    {
        $user = \App\Models\User::factory()->create();
        $order = Order::factory()->create(['id_user' => $user->id, 'status' => 'pending']);

        Auth::shouldReceive('id')->andReturn($user->id);

        $filter = Mockery::mock(\App\Contracts\Query\FilterContract::class);
        $repo = new EloquentOrderRepository(new Order(), $filter);

        $result = $repo->updateStatus(['status' => 'approved'], $order->id);

        $this->assertEquals('approved', $result->status);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'approved']);
    }

    public function test_update_status_denies_access_for_other_user()
    {
        $this->expectException(\App\Exceptions\ApiException::class);

        $user = \App\Models\User::factory()->create();
        $otherUser = \App\Models\User::factory()->create();

        $order = Order::factory()->create(['id_user' => $otherUser->id, 'status' => 'pending']);

        Auth::shouldReceive('id')->andReturn($user->id);

        $filter = Mockery::mock(\App\Contracts\Query\FilterContract::class);
        $repo = new EloquentOrderRepository(new Order(), $filter);

        $repo->updateStatus(['status' => 'approved'], $order->id);
    }
}
