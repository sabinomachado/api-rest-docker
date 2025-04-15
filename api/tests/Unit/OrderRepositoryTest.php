<?php

namespace Tests\Unit;

use App\Contracts\Query\FilterContract;
use App\Exceptions\ApiException;
use App\Models\City;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Order\EloquentOrderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $filter;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->filter = Mockery::mock(FilterContract::class);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_update_status_updates_the_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['id_user' => $user->id, 'status' => 'pending']);

        Auth::shouldReceive('id')->andReturn($user->id);

        $repository = new EloquentOrderRepository(new Order(), $this->filter);

        $result = $repository->updateStatus(['status' => 'confirmed'], $order->id);

        $this->assertEquals('confirmed', $result->status);
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'confirmed']);
    }

    public function test_update_status_denies_access_for_other_user()
    {
        $this->expectException(ApiException::class);

        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $order = Order::factory()->create(['id_user' => $otherUser->id, 'status' => 'pending']);

        Auth::shouldReceive('id')->andReturn($user->id);

        $repository = new EloquentOrderRepository(new Order(), $this->filter);

        $repository->updateStatus(['status' => 'confirmed'], $order->id);
    }

    public function test_all_returns_orders_for_logged_user()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Order::factory()->count(3)->create(['id_user' => $user->id]);

        Order::factory()->count(2)->create(['id_user' => $otherUser->id]);

        $repository = new EloquentOrderRepository(new Order(), $this->filter);

        Auth::shouldReceive('id')->andReturn($user->id);

        $result = $repository->all();

        $this->assertCount(3, $result);
    }

    public function test_all_orders_with_pagination()
    {
        $user = User::factory()->create();
        Order::factory()->count(15)->create(['id_user' => $user->id]);

        Auth::shouldReceive('id')->andReturn($user->id);

        $repository = new EloquentOrderRepository(new Order(), $this->filter);
        $repository->enablePagination();
        $repository->setPerPage(10);

        $result = $repository->all();

        $this->assertEquals(10, $result->count());
        $this->assertEquals(15, $result->total());
    }

    public function test_search_with_filters()
    {
        $user = User::factory()->create();
        $city1 = City::factory()->create(['name' => 'Porto Alegre']);
        $city2 = City::factory()->create(['name' => 'São Paulo']);
        $client = Client::factory()->create();

        Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city1->id,
            'id_client' => $client->id,
            'boarding_date' => '2025-04-14'
        ]);

        Order::factory()->create([
            'id_user' => $user->id,
            'id_city' => $city2->id,
            'id_client' => $client->id,
            'boarding_date' => '2025-04-15'
        ]);

        Auth::shouldReceive('id')->andReturn($user->id);

        $queryBuilder = Mockery::mock(Builder::class);
        $queryBuilder->shouldReceive('with')->andReturnSelf();
        $queryBuilder->shouldReceive('withCount')->andReturnSelf();
        $queryBuilder->shouldReceive('orderByRaw')->andReturnSelf();
        $queryBuilder->shouldReceive('get')->andReturn(collect([Order::find(1)]));

        $orderModel = Mockery::mock(Order::class);
        $orderModel->shouldReceive('newQuery')->andReturn($queryBuilder);

        $this->filter->shouldReceive('order')->andReturnSelf();

        $repository = new EloquentOrderRepository($orderModel, $this->filter);

        $options = [
            'filters' => [
                ['field' => 'city', 'value' => 'Porto']
            ]
        ];

        $result = $repository->search($options);

        $this->assertCount(1, $result);
    }
}
