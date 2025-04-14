<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        throw new HttpResponseException(response()->json([
            'message' => 'Erro na validação',
            'errors' => $validator->errors(),
        ], 422));
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
