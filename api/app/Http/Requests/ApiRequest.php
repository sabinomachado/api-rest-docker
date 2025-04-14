<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

abstract class ApiRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'load' => 'sometimes|nullable|array',
        ];
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws ApiException
     */
     protected function failedValidation(Validator $validator)
     {
         throw new ApiException(ApiException::VALIDATION, $this->formatErrors($validator));
     }

    /**
     * Handle a failed authorization attempt.
     *
     * @throws ApiException
     */
    protected function failedAuthorization()
    {
        throw new ApiException(ApiException::ACCESS_DENIED);
    }
}
