<?php

namespace App\Providers;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
