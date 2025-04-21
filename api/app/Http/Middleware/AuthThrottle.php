<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthThrottle
{
    private const MAX_ATTEMPTS = 5;
    private const DECAY_MINUTES = 5;
    private const RATE_LIMIT_KEY = 'auth:throttle:';

    public function handle(Request $request, Closure $next)
    {
        $realIp = $request->header('CF-Connecting-IP') ??
                  $request->header('X-Forwarded-For') ??
                  $request->ip();

        $key = self::RATE_LIMIT_KEY . $realIp;
        $attempts = RateLimiter::attempts($key);

        Log::info("Tentativa de acesso - IP: {$realIp}, Tentativas: {$attempts}/" . self::MAX_ATTEMPTS);

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            $secondsRemaining = RateLimiter::availableIn($key);
            
            Log::warning("IP bloqueado por muitas tentativas - IP: {$realIp}, Bloqueio restante: {$secondsRemaining}s");

            return response()->json([
                'error' => 'Muitas tentativas!',
                'message' => "Por favor, tente novamente em {$secondsRemaining} segundos.",
                'retry_after' => $secondsRemaining
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        RateLimiter::hit($key, self::DECAY_MINUTES * 60);

        Log::info("Middleware AuthThrottle acionado para {$request->path()} - IP: {$realIp}");

        return $next($request);
    }
}
