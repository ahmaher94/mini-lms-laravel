<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->loadMigrationsFrom([
            app_path('Modules/Course/Database/migrations'),
            app_path('Modules/User/Database/migrations'),
            app_path('Modules/Session/Database/migrations'),]);
    }
}
