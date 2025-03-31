<?php

use App\Http\Controllers\Api\Attachments\UploadAttachmentController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\Logoutcontroller;
use App\Http\Controllers\Api\Auth\Password\UpdatePasswordController;
use App\Http\Controllers\Api\Email\CheckEmailController;
use App\Http\Controllers\Api\Email\ConfirmOtpController;
use App\Http\Controllers\Api\Major\GetMajorController;
use App\Http\Controllers\Api\Major\GetMajorWithSubjectController;
use App\Http\Controllers\Api\Meeting\CreateMeetingController;
use App\Http\Controllers\Api\Note\CreateNoteController;
use App\Http\Controllers\Api\Posts\CreatePostController;
use App\Http\Controllers\Api\Role\GetRoleController;
use App\Http\Controllers\Api\Staff\ActivateStudentAccountController;
use App\Http\Controllers\Api\Staff\AllocateStudentTutorController;
use App\Http\Controllers\Api\Staff\CreateAutheroisedStaffAccountController;
use App\Http\Controllers\Api\Staff\CreateStudentAccountController;
use App\Http\Controllers\Api\Staff\CreateTutorAccountController;
use App\Http\Controllers\Api\Staff\DeactivateStudentAccountController;
use App\Http\Controllers\Api\Staff\GetStaffController;
use App\Http\Controllers\Api\Staff\ToggleStudentAccountController;
use App\Http\Controllers\Api\Staff\UnassignStudentTutorController;
use App\Http\Controllers\Api\Staff\UpdateStaffAccountController;
use App\Http\Controllers\Api\Staff\UpdateStudentAccountController;
use App\Http\Controllers\Api\Staff\UpdateTutorAccountController;
use App\Http\Controllers\Api\Students\GetStudentController;
use App\Http\Controllers\Api\Subjects\GetSubjectController;
use App\Http\Controllers\Api\Tutors\GetTutorController;
use App\Http\Controllers\Api\User\ChangePasswordController;
use App\Http\Controllers\Api\User\GetMeetingController;
use App\Http\Controllers\Api\User\GetNoteController;
use App\Http\Controllers\Api\User\GetPostController;
use App\Http\Controllers\Api\User\GetUserProfileController;
use App\Http\Controllers\GetMeetingPastController;
use App\Http\Controllers\GetStudentTutorController;
use App\Http\Controllers\GetTutoringSessionController;
use App\Http\Requests\Staff\ToggleUserAccountStatusRequest;
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

    Route::post('add-note', CreateNoteController::class);
    Route::get('notes', GetNoteController::class);

    Route::post('add-post', CreatePostController::class);
    Route::get('posts', GetPostController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('staffs', GetStaffController::class);
    Route::get('students', GetStudentController::class);
    Route::get('tutors', GetTutorController::class);
    Route::get('studentstutors', GetStudentTutorController::class);
    Route::get('subjects', GetSubjectController::class);
    Route::get('majors', GetMajorController::class);
    Route::get('roles', GetRoleController::class);
    Route::get('majors-with-subjects', GetMajorWithSubjectController::class);
    Route::get('tutoring_sessions', GetTutoringSessionController::class);
    Route::get('meetings', GetMeetingController::class);
    Route::get('meetingspast', GetMeetingPastController::class);
});



Route::get('check-email', CheckEmailController::class);
Route::get('confirm-otp', ConfirmOtpController::class);
Route::post('update-password', UpdatePasswordController::class);

Route::middleware('auth:sanctum')->prefix('students')->group(function () {
    Route::post('account/create', CreateStudentAccountController::class);
    Route::post('{id}/account/update', UpdateStudentAccountController::class);
    Route::post('account/deactivate', DeactivateStudentAccountController::class);
    Route::post('account/activate', ActivateStudentAccountController::class);
});

Route::middleware('auth:sanctum')->prefix('tutors')->group(function () {
    Route::post('account/create', CreateTutorAccountController::class);
    Route::post('{id}/account/update', UpdateTutorAccountController::class);
    Route::post('toggle/account/status', ToggleStudentAccountController::class);
    
});

Route::middleware('auth:sanctum')->prefix('staffs')->group(function () {
    Route::post('account/create', CreateAutheroisedStaffAccountController::class);
    Route::post('allocate-student-tutor', AllocateStudentTutorController::class);
    Route::post('unassign-student-tutor', UnassignStudentTutorController::class);
    Route::post('{id}/account/update', UpdateStaffAccountController::class);
    Route::post('toggle/account/status', ToggleStudentAccountController::class);
});

Route::post('upload-attachment', UploadAttachmentController::class);

Route::middleware('auth:sanctum')->prefix('posts')->group(function () {
    Route::post('create', CreatePostController::class);
});

Route::middleware('auth:sanctum')->prefix('meetings')->group(function () { 
    Route::post('create', CreateMeetingController::class);
});