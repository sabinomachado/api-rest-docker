<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception created for the API calls
 * It can be serialized into a JSON.
 *
 * @method errors()
 */
class ApiException extends Exception
{
    public const UNKNOWN = 1;

    public const USER_BLOCKED = 14;

    public const MIGRATION_PENDING = 42;

    public const PROCESSING = 102;

    public const VALIDATION = 400;

    public const TOKEN_EXPIRED = 401;

    public const TOKEN_INVALID = 402;

    public const ACCESS_DENIED = 403;

    public const NOT_FOUND = 404;

    public const USER_NOT_FOUND = 405;

    public const INVALID_API_KEY = 406;

    public const USER_NOT_VERIFIED = 407;

    public const USER_INVALID_EMAIL_TOKEN = 408;

    public const PAYMENT_ERROR = 409;

    public const TWO_FA_ERROR = 410;

    public const PASSWORD_NOT_MATCH = 411;

    public const METHOD_NOT_ALLOWED = 412;

    public const BAD_METHOD_CALL = 413;

    public const EMAIL_NOT_FOUND = 415;

    const UNEXPECTED_MATCH_VALUE            = 552;

    /**
     * Constructor.
     *
     * @param  int  $code  Code
     * @param  array  $data  Data of the exception
     */
    public function __construct($code = 1, $data = [])
    {
        $message = $message = config('api.errors.1');
        if (array_key_exists($code, config('api.errors'))) {
            $message = config('api.errors')[$code];
        }

        parent::__construct($message, $code);

        $this->data = $data;
    }

    /**
     * Serializes the exception into a json.
     *
     * @return array Json representation
     */
    public function toJson()
    {
        return [
            'error' => [
                'code' => $this->code,
                'message' => $this->message,
                'data' => $this->data,
            ],
        ];
    }

    /**
     * Gets the message of the exception.
     *
     * @return string message
     */
    public function message()
    {
        return $this->message;
    }
}
