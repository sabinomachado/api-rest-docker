<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\PaginatedRequest;

class SearchRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge((new PaginatedRequest())->rules(), [
            'filter' => 'nullable|string'
        ]);
    }

    /**
     * Prepare filters from request
     *
     * @return array
     */
    public function prepareFilters()
    {
        $params = [];
        $params['filters'] = [];

        if ($this->has('filter')) {
            $params['filters'][] = [
                'name' => 'table-search',
                'filter' => $this->filter,
            ];
        }

        if ($this->has('status')) {
            $params['filters'][] = [
                'name' => 'status',
                'filter' => $this->get('status'),
            ];
        }

        if ($this->has('city')) {
            $params['filters'][] = [
                'name' => 'city',
                'filter' => $this->get('city'),
            ];
        }

        if ($this->has('date_start') && $this->has('date_end')) {
            $params['filters'][] = [
                'name' => 'date_at_range',
                'start' => $this->get('date_start'),
                'end' => $this->get('date_end'),
            ];
        }

        return $params;
    }

    /**
     * Sanitize request
     *
     * @return array
     */
    public function sanitize()
    {
        $params = $this->onlyValidated();

        return $params;
    }
}
