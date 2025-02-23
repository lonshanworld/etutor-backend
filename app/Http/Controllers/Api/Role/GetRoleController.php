<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Roles\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class GetRoleController extends Controller
{
    public function __invoke()
    {
        return RoleResource::collection(
            Role::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get()
        );
    }
}
