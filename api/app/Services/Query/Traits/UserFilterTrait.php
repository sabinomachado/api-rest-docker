<?php

namespace App\Services\Query\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

trait UserFilterTrait
{
    /**
     * {@inheritdoc}
     */
    public function user(&$query, $options = [])
    {
        $name = Arr::get($options, 'name');
        switch ($name) {
            case 'table-search':
                $query = $this->userTableSearch($query, $options);
                break;
            case 'status':
                $query = $this->userStatus($query, $options);
                break;
            case 'status_array':
                $query = $this->userStatusArray($query, $options);
                break;
            default:
                break;
        }
    }

    /**
     * Filters a user to table search
     *
     * @param  Builder $query
     * @param  array $options
     * @return Builder
     */
    private function userTableSearch($query, $options = [])
    {
        $filter = Arr::get($options, 'filter');
        $filterParts = explode(' ', $filter);

        return $query->where(function ($query) use ($filterParts) {
            foreach ($filterParts as $part) {
                $query->where(function ($subQuery) use ($part) {
                    $subQuery->where('users.name', 'like', "%{$part}%")
                        ->orWhere('users.lastname', 'like', "%{$part}%");
                });
            }
        });
    }

    /**
     * Filters a user by the vigen status
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array                                 $options
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function userStatus($query, $options = [])
    {
        return $query->where('status', Arr::get($options, 'filter'));
    }

    /**
     * Filters a user by the given array ofstatus
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array                                 $options
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function userStatusArray($query, $options = [])
    {
        return $query->whereIn('status', Str::of(Arr::get($options, 'filter'))->explode(','));
    }
}
