<?php

use App\Http\Controllers\Api\Attachments\UploadAttachmentController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\Logoutcontroller;
use App\Http\Controllers\Api\Auth\Password\UpdatePasswordController;
use App\Http\Controllers\Api\Blog\CreateBlogController;
use App\Http\Controllers\Api\Blog\GetBlogController;
use App\Http\Controllers\Api\Blog\Likes\ToggleLikeToBlogController;
use App\Http\Controllers\Api\Blog\Comments\CommentToBlogController;
use App\Http\Controllers\Api\Blog\DeleteBlogController;
use App\Http\Controllers\Api\Blog\GetBlogByIdController;
use App\Http\Controllers\Api\Email\CheckEmailController;
use App\Http\Controllers\Api\Email\ConfirmOtpController;
use App\Http\Controllers\Api\Files\DeleteFileController;
use App\Http\Controllers\Api\Files\GetFilesController;
use App\Http\Controllers\Api\Files\DownloadFileController;
use App\Http\Controllers\Api\Major\GetMajorController;
use App\Http\Controllers\Api\Major\GetMajorWithSubjectController;
use App\Http\Controllers\Api\Meeting\CreateMeetingController;
use App\Http\Controllers\Api\Meeting\DeleteMeetingController;
use App\Http\Controllers\Api\Meeting\Records\CreateMeetingRecordController;
use App\Http\Controllers\Api\Meeting\Records\GetMeetingRecordController;
use App\Http\Controllers\Api\Meeting\GetMeetingController;
use App\Http\Controllers\Api\Meeting\GetRecentMeetingController;
use App\Http\Controllers\Api\Note\CreateNoteController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Reports\GetActiveUserController;
use App\Http\Controllers\Api\Reports\GetBrowserUsageController;
use App\Http\Controllers\Api\Reports\GetViewPageController;
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
use App\Http\Controllers\Api\TutoringSessions\GetStudentsByTutorController;
use App\Http\Controllers\Api\TutoringSessions\GetTutorByStudentController;
use App\Http\Controllers\Api\Tutors\GetTutorController;
use App\Http\Controllers\Api\User\ChangePasswordController;
use App\Http\Controllers\Api\User\GetNoteController;
use App\Http\Controllers\Api\User\GetUserProfileController;
use App\Http\Controllers\GetStudentTutorController;
use App\Http\Controllers\GetTutoringSessionController;
use App\Http\Resources\Api\Users\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth:sanctum')->prefix('auth')->group(function () {
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
});

Route::get('check-email', CheckEmailController::class);
Route::get('confirm-otp', ConfirmOtpController::class);
Route::post('update-password', UpdatePasswordController::class);

Route::middleware('auth:sanctum')->prefix('students')->group(function () {
    Route::post('account/create', CreateStudentAccountController::class);
    Route::post('{id}/account/update', UpdateStudentAccountController::class);
    Route::post('account/deactivate', DeactivateStudentAccountController::class);
    Route::post('account/activate', ActivateStudentAccountController::class);
    Route::get('my-tutor', GetTutorByStudentController::class);
});

Route::middleware('auth:sanctum')->prefix('tutors')->group(function () {
    Route::post('account/create', CreateTutorAccountController::class);
    Route::post('{id}/account/update', UpdateTutorAccountController::class);
    Route::post('toggle/account/status', ToggleStudentAccountController::class);
    Route::post('account/deactivate', DeactivateStudentAccountController::class);
    Route::post('account/activate', ActivateStudentAccountController::class);
    Route::get('my-students', GetStudentsByTutorController::class);
});

Route::middleware('auth:sanctum')->prefix('staffs')->group(function () {
    Route::post('account/create', CreateAutheroisedStaffAccountController::class);
    Route::post('allocate-student-tutor', AllocateStudentTutorController::class);
    Route::post('unassign-student-tutor', UnassignStudentTutorController::class);
    Route::post('{id}/account/update', UpdateStaffAccountController::class);
    Route::post('toggle/account/status', ToggleStudentAccountController::class);
    Route::post('account/deactivate', DeactivateStudentAccountController::class);
    Route::post('account/activate', ActivateStudentAccountController::class);
});

Route::post('upload-attachment', UploadAttachmentController::class);

Route::middleware('auth:sanctum')->get('/files/{id}/download', DownloadFileController::class);

Route::middleware('auth:sanctum')->prefix('blogs')->group(function () {
    Route::get('/', GetBlogController::class);
    Route::get('files', GetFilesController::class);
    Route::get('/{id}', GetBlogByIdController::class);
    Route::post('add', CreateBlogController::class);
    Route::post('delete-file', DeleteFileController::class);
    Route::post('give-like', ToggleLikeToBlogController::class);
    Route::post('give-comment', CommentToBlogController::class);
    Route::post('/{blog}/delete', DeleteBlogController::class);
});

Route::middleware('auth:sanctum')->prefix('meetings')->group(function () {
    Route::post('create', CreateMeetingController::class);
    Route::get('/', GetMeetingController::class);
    Route::get('recent', GetRecentMeetingController::class);
    Route::delete('/{meeting}', DeleteMeetingController::class);

    Route::prefix('records')->group(function () {
        Route::get('/', GetMeetingRecordController::class);
        Route::post('/', CreateMeetingRecordController::class);
    }); 
});

// Notification routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'getAllNotifications']);
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead']);
});

Route::middleware('auth:sanctum')->prefix('reports')->group(function () {
    Route::get('view-pages', GetViewPageController::class);
    Route::get('active-users', GetActiveUserController::class);
    Route::get('browser-usage', GetBrowserUsageController::class);
});
