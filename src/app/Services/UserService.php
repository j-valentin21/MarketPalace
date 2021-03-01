<?php

namespace App\Services;


use App\Models\User;

class UserService
{
    /**
     *
     * @param $user
     * @return string[]
     */
    public function validationRulesUpdate($user)
    {
        return [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];
    }
}
