<?php

namespace App\Providers;

use App\DAO\UserDAOImpl;
use App\Http\DAO\SourceDonnes\UserDAO;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserDAO::class, \App\Http\DAO\UserDAOImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
