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
                $query->where('name', 'admin')
                    ->orWhere('name', 'staff');
            })
            ->when($request->search, function($query) use($request) {
                $query->where(function($q) use($request) {
                    $q->where('email', $request->search)
                        ->orWhere('first_name', 'like', '%'.$request->search.'%')
                        ->orWhere('middle_name', 'like', '%'.$request->search.'%')
                        ->orWhere('last_name', 'like', '%'.$request->search.'%');
                });
            })
            ->paginate(config('app.paginate.count'));

            return StaffResource::collection($staffs);
        } catch (\Throwable $th) {
            return response()->error();
        }
    }
}
