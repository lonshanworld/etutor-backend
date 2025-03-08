<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Staff\StaffResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetStaffController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $staffs = User::whereHas('role', function ($query) {
                $query->where('name', 'staff');
            })
            ->when($request->name, function($query) use($request) {
                $query->where('first_name', 'like', '%'.$request->name.'%')
                    ->orWhere('middle_name', 'like', '%'.$request->name.'%')
                    ->orWhere('last_name', 'like', '%'.$request->name.'%');
            })
            ->paginate(config('app.paginate.count'));

            return StaffResource::collection($staffs);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
