<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\User\UserRepositoryInterface;

class AuthController extends Controller
{
    private UserRepositoryInterface $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->middleware('auth:sanctum')->only(['logout', 'refresh', 'me']);
        $this->user = $user;
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->user->login($request);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        return $this->user->logout();
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->user->refresh();
    }

    public function me(): \Illuminate\Http\JsonResponse
    {
        return $this->user->me();
    }
}
