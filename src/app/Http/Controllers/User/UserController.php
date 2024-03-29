<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\UserCreated;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{
    private UserService $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;

        $this->middleware('client.credentials')->only(['resend']);
        $this->middleware('auth:api')->except(['showRegisterForm', 'store', 'verify', 'resend']);
        $this->middleware('transform.input:' . UserResource::class)->only(['update']);
        $this->middleware('scope:manage-account')->only(['show', 'update']);
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->allowedAdminAction();

        $user = User::all();

        return $this->showAll($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request);
        Mail::to($user->email)->send(new UserCreated($user));

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->userService->newEmailVerification($request,$user);
        $this->userService->updateUser($request,$user);

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->showOne($user);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('The account has been verified successfully');
    }

    public function resend(User $user)
    {
        if ($user->verified == User::VERIFIED_USER) {
            return $this->errorResponse('This user is already verified', 409);
        }

        Mail::to($user)->send(new UserCreated($user));

        return $this->showMessage('The verification email has been resend');
    }
}
