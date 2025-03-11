<?php

namespace App\Http\Repositories\UserRepository;

use App\Models\User;

class UserRepository
{
    public function getUserById(string $id)
    {
        return User::where('id', $id)->first();
    }
}
