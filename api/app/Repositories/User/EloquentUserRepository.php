<?php

namespace App\Repositories\User;

use App\Exceptions\ApiException;
use App\Models\User;
use App\Repositories\Crud\EloquentCrudRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EloquentUserRepository extends EloquentCrudRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //    public function all($with = [], $order = null): \Illuminate\Http\JsonResponse
    //    {
    //
    //    }

    public function login($request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        if (! $user) {
            throw new ApiException('Usuário não autenticado', 401);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function me(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        if (! $user) {
            throw new ApiException('Usuário não autenticado', 401);
        }

        return response()->json($user);
    }
}
