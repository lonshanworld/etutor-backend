<?php

namespace App\Providers;

use App\Listeners\UpdateSessionLoginTime;
use App\Listeners\UpdateSessionLogoutTime;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Laravel\Reverb\Events\ConnectionPruned::class => [
            UpdateSessionLogoutTime::class
        ],
    ];

    public function boot(): void
    {
        //
    }
}
