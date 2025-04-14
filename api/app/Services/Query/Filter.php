<?php

namespace App\Services\Query;

use App\Contracts\Query\FilterContract;

class Filter implements FilterContract
{
    use Traits\UserFilterTrait;
    use Traits\OrderFilterTrait;
}
