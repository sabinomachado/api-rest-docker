<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception created for the API calls
 * It can be serialized into a JSON.
 * @method errors()
 */
class ApiException extends Exception
{
    const UNKNOWN                    = 1;

    const USER_BLOCKED               = 14;
    const MIGRATION_PENDING          = 42;
    const PROCESSING                 = 102;
    const VALIDATION                 = 400;
    const TOKEN_EXPIRED              = 401;
    const TOKEN_INVALID              = 402;
    const ACCESS_DENIED              = 403;
    const NOT_FOUND                  = 404;
    const USER_NOT_FOUND             = 405;
    const INVALID_API_KEY            = 406;
    const USER_NOT_VERIFIED          = 407;
    const USER_INVALID_EMAIL_TOKEN   = 408;
    const PAYMENT_ERROR              = 409;
    const TWO_FA_ERROR               = 410;
    const PASSWORD_NOT_MATCH         = 411;
    const METHOD_NOT_ALLOWED         = 412;
    const BAD_METHOD_CALL            = 413;
    const EMAIL_NOT_FOUND            = 415;

    /**
     * Constructor.
     *
     * @param int   $code Code
     * @param array $data Data of the exception
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
