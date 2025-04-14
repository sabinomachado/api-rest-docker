<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\ApiRequest;

class UpdateStatusRequest extends ApiRequest
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
            'status' => 'required|in:pending,canceled,confirmed',
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
