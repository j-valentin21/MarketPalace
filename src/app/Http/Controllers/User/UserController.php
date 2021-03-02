<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = User::all();

        return response()->json(['data' => $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->createUser($request);

        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function show(User $user): User
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->json($request->validator->messages(), 422);
        }
        $this->userService->updateUser($request,$user);

        return response()->json(['data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['data' => $user], 200);
    }
}
