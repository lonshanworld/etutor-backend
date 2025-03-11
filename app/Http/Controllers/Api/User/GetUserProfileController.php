<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository\UserRepository;
use App\Http\Resources\Api\Users\UserProfileResource;

class GetUserProfileController extends Controller
{
    public function __invoke(string $id, UserRepository $userRepository)
    {
        return new UserProfileResource(
            $userRepository->getUserById($id)
        );
    }
}
