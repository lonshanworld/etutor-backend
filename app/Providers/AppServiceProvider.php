<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Numeric;
use Illuminate\Routing\UrlGenerator;

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
    public function boot(UrlGenerator $url): void
    {   
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
        
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Response::macro('success', function(array $data = [], string $message, int $status = 200) {
            return response()->json([
                'data' => $data,
                'message' => $message,
                
            ], $status);
        });

        Response::macro('error', function($message = 'Oops! Something went wrong!', $status = 500) {
            return response()->json([
                'message' => $message,
                'errorMessage' => $message
            ], $status);
        });

    }
}
