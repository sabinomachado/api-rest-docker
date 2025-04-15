<?php

namespace App\Services\Query\Traits;

use App\Models\City;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

trait OrderFilterTrait
{
    /**
     * {@inheritdoc}
     */
    public function order(&$query, $options = [])
    {
        $name = Arr::get($options, 'name');
        switch ($name) {
            case 'table-search':
                $query = $this->orderTableSearch($query, $options);
                break;
            case 'status':
                $query = $this->orderStatus($query, $options);
                break;
            case 'city':
                $query = $this->orderCity($query, $options);
                break;
            case 'date_range':
                $query = $this->orderDateRange($query, $options);
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
    private function orderTableSearch($query, $options = [])
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
    private function orderStatus($query, $options = [])
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
    private function orderCity($query, $options = [])
    {
        $filter = Arr::get($options, 'filter');

        $cityIds = City::query()
            ->where('name', 'like', "%$filter%")
            ->orWhere('id', $filter)
            ->pluck('id')
            ->toArray();

        return $query->whereIn('id_city', $cityIds);
    }

    /**
     * Filters a user by the start date
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  array                                 $options
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function orderDateRange($query, $options = [])
    {
        $start = Arr::get($options, 'start');
        $end = Arr::get($options, 'end');


        if ($start && $end) {
            $startDate = Carbon::parse($start)->startOfDay();
            $endDate = Carbon::parse($end)->endOfDay();

            $query->whereBetween('boarding_date', [$startDate, $endDate])
                ->whereBetween('return_date', [$startDate, $endDate]);
        }

        return $query;
    }
}
