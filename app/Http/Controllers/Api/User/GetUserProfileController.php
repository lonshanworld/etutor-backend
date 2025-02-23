<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\UserProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetUserProfileController extends Controller
{
    public function __invoke(string $id)
    {
        return new UserProfileResource(User::where('id', $id)->first());
    }
}
