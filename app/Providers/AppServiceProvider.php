<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**c
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
    Paginator::defaultView('vendor.pagination.custom');
}
}
