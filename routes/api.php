<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\Logoutcontroller;
use App\Http\Controllers\Api\Auth\Password\UpdatePasswordController;
use App\Http\Controllers\Api\Email\CheckEmailController;
use App\Http\Controllers\Api\Email\ConfirmOtpController;
use App\Http\Controllers\Api\Major\GetMajorController;
use App\Http\Controllers\Api\Major\GetMajorWithSubjectController;
use App\Http\Controllers\Api\Role\GetRoleController;
use App\Http\Controllers\Api\Staff\AllocateStudentTutorController;
use App\Http\Controllers\Api\Staff\CreateAutheroisedStaffAccountController;
use App\Http\Controllers\Api\Staff\CreateStudentAccountController;
use App\Http\Controllers\Api\Staff\CreateTutorAccountController;
use App\Http\Controllers\Api\Staff\DeactivateStudentAccountController;
use App\Http\Controllers\Api\Staff\GetStaffController;
use App\Http\Controllers\Api\Staff\UpdateStudentAccountController;
use App\Http\Controllers\Api\Students\GetStudentController;
use App\Http\Controllers\Api\Subjects\GetSubjectController;
use App\Http\Controllers\Api\Tutors\GetTutorController;
use App\Http\Controllers\Api\User\ChangePasswordController;
use App\Http\Controllers\Api\User\GetUserProfileController;
use App\Http\Resources\Api\Users\UserProfileResource;
use App\Mail\User\WelcomeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('login', LoginController::class)->middleware('guest');
    Route::post('logout', Logoutcontroller::class)->middleware(['auth:sanctum']);
});

// Route::middleware('auth:sanctum')->get('user/{id}/profile', GetUserProfileController::class);

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('profile', function (Request $request) {
        return new UserProfileResource($request->user());
    });
    Route::get('/{id}/profile', GetUserProfileController::class);
    Route::post('change-password', ChangePasswordController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('staffs', GetStaffController::class);
    Route::get('students', GetStudentController::class);
    Route::get('tutors', GetTutorController::class);
    Route::get('subjects', GetSubjectController::class);
    Route::get('majors', GetMajorController::class);
    Route::get('roles', GetRoleController::class);
    Route::get('majors-with-subjects', GetMajorWithSubjectController::class);
});



Route::get('check-email', CheckEmailController::class);
Route::get('confirm-otp', ConfirmOtpController::class);
Route::post('update-password', UpdatePasswordController::class);

Route::middleware('auth:sanctum')->prefix('students')->group(function () {
    Route::post('account/create', CreateStudentAccountController::class);
    Route::post('{id}/account/update', UpdateStudentAccountController::class);
    Route::post('account/deactivate', DeactivateStudentAccountController::class);
});

Route::middleware('auth:sanctum')->prefix('tutors')->group(function () {
    Route::post('account/create', CreateTutorAccountController::class);
    // Route::post('{id}/account/update', UpdateTutorAccountController::class);
    // Route::post('account/deactivate', DeactivateTutorAccountController::class);
});

Route::middleware('auth:sanctum')->prefix('staffs')->group(function () {
    Route::post('account/create', CreateAutheroisedStaffAccountController::class);
    Route::post('allocate-student-tutor', AllocateStudentTutorController::class);
    //     Route::post('{id}/account/update', UpdateStaffAccountController::class);
    //     Route::post('account/deactivate', DeactivateStaffAccountController::class);
});

Route::middleware('auth:sanctum')->prefix('upload/attachments')->group(function () {
    Route::post('/', function (Request $request) {
        dd(
            $request->file('images'),
            $request->file('documents'),
            $request->file('videos')
        );
        // attachments[] file will come with this key save all the file to the aws light sail

        $path = $file->store('etuto/profile', 's3');
        $validatedData['profile_picture'] = Storage::disk('s3')->url($path);
    });
});