<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NoteResource;
use Illuminate\Http\Request;

class GetNoteController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            return NoteResource::collection(auth('sanctum')->user()->notes->load('files'));
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}