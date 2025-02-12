<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Logoutcontroller extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->noContent();
        } catch (\Throwable $th) {
            throw $th;
            return response()->error();
        }
    }
}
