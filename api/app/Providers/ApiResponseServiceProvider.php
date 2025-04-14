<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $response = app(ResponseFactory::class);

        $response::macro('success', function (string $description, int $httpStatusCode, array $data = []) {
            return response()->json(
                [
                    'success' => [
                        'code' => $httpStatusCode,
                        'message' => $description,
                        'data' => $data
                    ],
                ],
                $httpStatusCode
            );
        });

        $response::macro('error', function (string $description, int $httpStatusCode, array $data = []) {
            return response()->json(
                [
                    'error' => [
                        'code' => $httpStatusCode,
                        'message' => $description,
                        'data' => $data
                    ],
                ],
                $httpStatusCode
            );
        });

        $response::macro('internal', function (bool $success, string $message, array $data = []) {
            return response()->json(
                [
                    'success' => [
                        'code' => 500,
                        'message' => $message,
                        'data' => $data
                    ],
                ],
                500
            );
        });
    }
}
