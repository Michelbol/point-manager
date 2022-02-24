<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function findUserByUsername(string $username)
    {
        return User::whereUsername($username)->first();
    }

    public function createUserByUsername(string $username)
    {
        return User::create(['username' => $username]);
    }

    public function updateApiToken(User $user, string $apiToken)
    {
        $user->api_token = $apiToken;
        $user->save();
    }
}
