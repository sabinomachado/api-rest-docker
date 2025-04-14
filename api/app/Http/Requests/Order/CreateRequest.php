<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Fluent;

class CreateRequest extends ApiRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_client' => 'required|int|exists:clients,id',
            'id_city' => 'required|int|exists:cities,id',
            'id_user' => 'required|int|exists:users,id',
            'boarding_date' => 'required|date_format:Y-m-d',
            'return_date' => 'required|date_format:Y-m-d',
        ];
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

    public function withValidator($validator)
    {
        $validator->sometimes(
            ['co_debtor_name', 'co_debtor_phone', 'co_debtor_email', 'co_debtor_cpf'],
            'required',
            function (Fluent $input) {
                return !empty($input->co_debtor_name)
                    || !empty($input->co_debtor_phone)
                    || !empty($input->co_debtor_email)
                    || !empty($input->co_debtor_cpf);
            }
        );

        $validator->sometimes(
            ['witness_name', 'witness_phone', 'witness_email', 'witness_cpf'],
            'required',
            function (Fluent $input) {
                return !empty($input->witness_name)
                    || !empty($input->witness_phone)
                    || !empty($input->witness_email)
                    || !empty($input->witness_cpf);
            }
        );
    }
}
