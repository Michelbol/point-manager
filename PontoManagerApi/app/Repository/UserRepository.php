<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Carbon;

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

    public function updateUser(User $user, array $fields)
    {
        $user->update($fields);
    }

    public function findUserLoggedByApiToken(string $apiToken)
    {
        return User
            ::where('api_token', $apiToken)
            ->where('task_expire_at', '>', Carbon::now())
            ->first();
    }
}
