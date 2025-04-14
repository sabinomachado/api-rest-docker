<?php

namespace App\Repositories\Order;

use App\Repositories\Crud\CrudRepository;

interface OrderRepositoryInterface extends CrudRepository
{
    public function search($data);

    public function updateStatus($data, $id);
}
