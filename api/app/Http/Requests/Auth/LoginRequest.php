<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends ApiRequest
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
     * @return array<string, ApiRequest|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'E-mail inválido, corrija este campo.'
        ];
    }
}
