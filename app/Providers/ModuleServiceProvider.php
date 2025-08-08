<?php

namespace App\Providers;

use App\Modules\Course\Domain\Contracts\CourseRepositoryInterface;
use App\Modules\Course\Repositories\EloquentCourseRepository;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, EloquentCourseRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
