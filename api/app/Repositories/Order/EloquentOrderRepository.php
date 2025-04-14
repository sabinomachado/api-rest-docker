<?php

namespace App\Repositories\Order;

use App\Contracts\Query\FilterContract;
use App\Models\Order;
use App\Repositories\Crud\EloquentCrudRepository;
use Illuminate\Support\Arr;


/**
 * @property Order  $model
 *
 **/

class EloquentOrderRepository extends EloquentCrudRepository implements OrderRepositoryInterface
{
    public function __construct(
        Order $order,
        FilterContract          $filter,
    ) {
        $this->model = $order;
        $this->filter = $filter;
    }


    public function all($with = [], $order = null, $type = null)
    {
        $query = $this->model->with($with);
        if (!empty($order)) {
            $query->orderBy($order);
        }

        if ($this->paginate) {
            return $query->paginate($this->perPage);
        } else {
            return $query->get();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function search($options = [], $with = [], $withCount = [], $order = null, $type = null)
    {
        $query = $this->model->newQuery()->with($with)->withCount($withCount);

        foreach (Arr::get($options, 'filters', []) as $filter) {
            $this->filter->order($query, $filter);
        }

        if (! is_null($order)) {
            $query->orderByRaw($order);
        }

        if ($this->paginate) {
            return $query->paginate($this->perPage);
        } else {
            return $query->get();
        }
    }

}
