<?php

namespace App\Providers;


use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */


     protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        // Add your custom event here
        \App\Events\NewCaseCreated::class => [
            \App\Listeners\SendCaseNotifications::class,
        ],
    ];

    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
