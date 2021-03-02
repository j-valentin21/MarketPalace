<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Update user data from request
     *
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

        $user->save();
    }
}
