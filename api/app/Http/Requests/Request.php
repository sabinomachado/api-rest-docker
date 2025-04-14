<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Validate the input.
     *
     * @param  \Illuminate\Validation\Factory $factory
     * @return \Illuminate\Validation\Validator
     */
    public function validator($factory)
    {
        return $factory->make(
            $this->sanitizeInput(),
            $this->container->call([$this, 'rules']),
            $this->messages()
        );
    }

    /**
     * Sanitize the input.
     *
     * @return array
     */
    protected function sanitizeInput()
    {
        if (method_exists($this, 'sanitize')) {
            return $this->container->call([$this, 'sanitize']);
        }

        return $this->all();
    }

    /**
     * Only gets the validated parameters.
     *
     * @param  bool $emptyToNull Convert empty values to null ? (false)
     * @return array Array containing the validated values
     */
    public function onlyValidated($emptyToNull = false)
    {
        $rules = collect(array_keys($this->rules()))->reject(
            function ($value) {
                return str_contains($value, '*');
            }
        )->all();

        return $this->only($rules, $emptyToNull);
    }

    /**
     * Gets all parameters trimmed.
     *
     * @return Request
     */
    public function trimmed()
    {
        $request = $this;
        $input = $request->all();
        $request->merge(array_map('trim_recursive', $input));

        return $request;
    }
}
