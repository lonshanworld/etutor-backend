<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\Logoutcontroller;
use App\Http\Controllers\Api\Auth\Password\UpdatePasswordController;
use App\Http\Controllers\Api\Email\CheckEmailController;
use App\Http\Controllers\Api\Email\ConfirmOtpController;
use App\Http\Controllers\Api\Role\GetRoleController;
use App\Http\Controllers\Api\Staff\CreateStudentAccountController;
use App\Http\Controllers\Api\Staff\DeactivateStudentAccountController;
use App\Http\Controllers\Api\Staff\GetStaffController;
use App\Http\Controllers\Api\Students\GetStudentController;
use App\Http\Controllers\Api\Tutors\GetTutorController;
use App\Http\Controllers\Api\User\GetUserProfileController;
use App\Mail\User\WelcomeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('login', LoginController::class)->middleware('guest');
    Route::post('logout', Logoutcontroller::class)->middleware(['auth:sanctum']);
});

Route::get('user/{id}/profile', GetUserProfileController::class);

Route::get('staffs', GetStaffController::class);
Route::get('students', GetStudentController::class);
Route::get('tutors', GetTutorController::class);
Route::get('roles', GetRoleController::class);

Route::get('send-mail', function() {
    Mail::to(
        User::first()->email->send(new WelcomeUser($message = 'hello'))
    );
}); 

Route::get('check-email', CheckEmailController::class);
Route::get('confirm-otp', ConfirmOtpController::class);
Route::post('update-password', UpdatePasswordController::class);

Route::middleware(['auth:sanctum'])->post('students/account/create', CreateStudentAccountController::class);
Route::middleware(['auth:sanctum'])->post('students/account/deactivate', DeactivateStudentAccountController::class);