<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Numeric;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        Response::macro('success', function(array $data = [], string $message = 'success', int $status = 200): JsonResponse {
            return response()->json([
                'data' => $data,
                'message' => $message,
            ], $status);
        });

        Response::macro('error', function(string $message = 'Oops! Something went wrong!', int $status = 500): JsonResponse {
            return response()->json([
                'message' => $message,
                'errorMessage' => $message
            ], $status);
        });
    }
}
