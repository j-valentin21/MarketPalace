<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        $validated['verified'] = User::UNVERIFIED_USER;
        $validated['verification_token'] = User::generateVerificationCode();
        $validated['admin'] = User::REGULAR_USER;

        $user = User::create($validated);

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
