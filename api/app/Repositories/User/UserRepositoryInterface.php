<?php

namespace App\Repositories\User;

use App\Repositories\Crud\CrudRepository;

interface UserRepositoryInterface extends CrudRepository
{
    /**
     * Login user
     *
     * @param  array  $data
     */
    public function login($data): \Illuminate\Http\JsonResponse;

    /**
     * Logout user
     */
    public function logout(): \Illuminate\Http\JsonResponse;

    /**
     * Refresh token
     */
    public function refresh(): \Illuminate\Http\JsonResponse;

    /**
     * Get authenticated user
     */
    public function me(): \Illuminate\Http\JsonResponse;

    //    /**
    //     * Get All Users
    //     *
    //     * @param  array $data
    //     * @return \Illuminate\Http\JsonResponse
    //     */
    //    public function all(): \Illuminate\Http\JsonResponse;
    //
    //
    //    /**
    //     * Searcj
    //     *
    //     * @param  array $data
    //     * @return \Illuminate\Http\JsonResponse
    //     */
    //    public function search(): \Illuminate\Http\JsonResponse;
}
