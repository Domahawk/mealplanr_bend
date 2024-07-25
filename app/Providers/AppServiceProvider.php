<?php

namespace App\Providers;

use App\Pagination\CustomPaginator;
use App\Services\CreateMealService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->alias(CustomPaginator::class, LengthAwarePaginator::class); // Eloquent uses the class instead of the contract
        $this->app->alias(CustomPaginator::class, LengthAwarePaginatorContract::class);
        $this->app->singleton(CreateMealService::class, fn () => new CreateMealService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
