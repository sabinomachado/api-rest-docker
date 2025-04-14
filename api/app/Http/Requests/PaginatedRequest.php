<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class PaginatedRequest extends ApiRequest
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
        return array_merge(
            parent::rules(),
            [
            'page' => 'numeric|min:0',
            'limit' => 'numeric|min:0',
            ]
        );
    }
}
