<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AllRequest;
use App\Http\Requests\Order\CreateRequest;
use App\Http\Requests\Order\SearchRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Requests\Order\UpdateStatusRequest;
use App\Http\Resource\Order\OrderResource;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderController extends Controller
{
    private OrderRepositoryInterface $order;

    public function __construct(OrderRepositoryInterface $user)
    {
        //$this->middleware('auth:sanctum');
        $this->order = $user;
    }

    /**
     * Get all Users
     *
     * @param AllRequest $request
     */
    public function index(AllRequest $request)
    {
        return OrderResource::collection(
            $this->order
            ->enablePagination()
            ->setPerPage($request->get(')
                limit', config('api.common.default-page-size')))
            ->all($request->get('load', []), $request->order)
        );
    }

    /**
     * Create a new Order.
     *
     * @param CreateRequest    $request
     *
     */
    public function store(CreateRequest $request)
    {
        return $this->order->create($request->sanitize());
    }

    /**
     * Search entitys
     *
     */
    public function search(SearchRequest $request)
    {

        return OrderResource::collection(
            $this->order
                ->enablePagination()
                ->setPerPage($request->get('limit', config('api.common.default-page-size')))
                ->search($request->prepareFilters(), $request->get('load', []), [], $request->order, $request->type)
        );
    }

    /**
     * Shows order details.
     *
     * @param int $entityId
     *
     */
    public function show($orderId)
    {
        return new OrderResource($this->order->find($orderId));
    }

    /**
     * Update Order details.
     *
     * @param  $request
     * @param $orderId
     * @return mixed
     */
    public function update(UpdateRequest $request, $orderId)
    {
        if ($this->order->update($orderId, $request->sanitize())) {
            return response()->success(config('api.order.update-success'), 200);
        }

        return response()->error(config('api.order.update-error'), 422);
    }

    /**
     * Delete a Order.
     *
     * @param int   $orderId
     */
    public function destroy($orderId)
    {

        if ($this->order->delete($orderId)) {
            return response()->success(config('api.order.delete-success'), 200);
        }

        return response()->error(config('api.order.delete-error'), 422);
    }

    /**
     * Update Order status.
     *
     * @param  $request
     * @return mixed
     */

    public function updateStatus(UpdateStatusRequest $request, $orderId)
    {
        return new OrderResource($this->order->updateStatus($request->sanitize(), $orderId));
    }
}
