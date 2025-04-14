<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\ApiRequest;

class UpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_client' => 'required|int|exists:clients,id',
            'id_city' => 'required|int|exists:cities,id',
            'id_user' => 'required|int|exists:users,id',
            'boarding_date' => 'required|date_format:Y-m-d',
            'return_date' => 'required|date_format:Y-m-d',
            'status' => 'required|in:pending,confirmed,canceled',
        ];
    }

    /**
     * Sanitize request
     *
     * @return array
     */
    public function sanitize()
    {
        return $this->onlyValidated();
    }
}
