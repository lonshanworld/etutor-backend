<?php

use App\Http\Controllers\Api\Account\CreateAccountController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\Logoutcontroller;
use App\Http\Controllers\Api\Students\GetStudentController;
use App\Http\Controllers\Api\Tutors\GetTutorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// abc.com/api/auth/login [post request]

Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('login', LoginController::class)->middleware('guest');
    Route::post('logout', Logoutcontroller::class)->middleware(['auth:sanctum']);
});

Route::post('accounts/create', CreateAccountController::class);

Route::get('students', GetStudentController::class);
Route::get('tutors', GetTutorController::class);