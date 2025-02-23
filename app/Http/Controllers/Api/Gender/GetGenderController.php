<?php

namespace App\Http\Controllers\Api\Gender;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Gender\GenderResource;
use App\Models\Gender;
use Illuminate\Http\Request;

class GetGenderController extends Controller
{
    public function __invoke()
    {
        return GenderResource::collection(
            Gender::select('id', 'name')
                ->orderBy('name', 'asc')
                ->get()
        );
    }
}
