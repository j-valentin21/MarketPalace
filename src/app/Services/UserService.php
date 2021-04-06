<?php

namespace App\Services;

use App\Mail\UserMailChanged;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     * Create new user from request data
     *
     * @param $request
     */
    public function createUser($request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($request->password);
        $validated['verified'] = User::UNVERIFIED_USER;
        $validated['verification_token'] = User::generateVerificationCode();
        $validated['admin'] = User::REGULAR_USER;

       return User::create($validated);
    }

    /**
     * Update user data from request
     *
     * @param $request
     * @param User $user
     */
    public function updateUser ($request, User $user)
    {
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('admin')) {

            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }

            $user->admin = $request->admin;
        }

        $user->save();
    }

    /**
     * Create new user from request data
     *
     * @param $request
     * @param $user
     */
    public function newEmailVerification($request, $user)
    {
        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
            Mail::to($user->email)->send(new UserMailChanged($user));
        }
    }

}
