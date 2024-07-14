<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\CRUD\CrudInterface;
use App\Repositories\PostRepository;
use App\Services\CrudService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CrudInterface::class, PostRepository::class);
        $this->app->bind(CrudInterface::class, CommentRepository::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
