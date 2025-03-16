 <?php

//namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;

use App\Http\Requests\Staff\CreateStudentAccountRequest;
use App\Http\Requests\Staff\CreateUserAccountRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;

// class CreateAccountController extends Controller
// {
//     public function __invoke(CreateStudentAccountRequest $createUserAccountRequest)
//     {
//         try {
//             User::create($createUserAccountRequest->validated());
//             return response()->success([], 'User account created successfully.', 200);
//         } catch (\Throwable $th) {
//             return response()->error('An error occurred while creating the account.', 500);
//         }
//     }
// } 
?>
