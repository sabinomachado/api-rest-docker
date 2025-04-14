<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AllRequest;
use App\Http\Resource\User\UserResourceLight;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    private UserRepositoryInterface $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->middleware('auth:sanctum');
        $this->user = $user;
    }

    /**
     * Get all Users
     *
     * @param AllRequest $request
     */
        public function index(AllRequest $request)
    {
        return UserResourceLight::collection(
            $this->user
                ->enablePagination()
                ->setPerPage($request->get(')
                limit', config('api.common.default-page-size')))
                ->all($request->get('load', []), $request->order)
        );
    }

}
