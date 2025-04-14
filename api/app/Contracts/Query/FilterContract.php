<?php

namespace App\Contracts\Query;

use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    /**
     * Applies the filter to a user query.
     *
     * @param Builder &$query
     * @param array                                 $options
     */
    public function user(Builder &$query, array $options = []);


    /**
     * Applies the filter to a order query.
     *
     * @param Builder &$query
     * @param array                                 $options
     */
    public function order(Builder &$query, array $options = []);
}
