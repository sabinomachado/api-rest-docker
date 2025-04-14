<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    private UserRepositoryInterface $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->middleware('auth:sanctum');
        $this->user = $user;
    }


}
