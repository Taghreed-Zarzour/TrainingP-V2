<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
    Passport::personalAccessTokensExpireIn(now()->addHours(2));

    if (request()->has('remember') && request()->remember == true) {
        Passport::personalAccessTokensExpireIn(now()->addDays(7));
    }
    }
}
