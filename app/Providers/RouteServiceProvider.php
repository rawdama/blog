<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class RouteServiceProvider extends ServiceProvider
{
    
    public const HOME = '/dashboard';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        

    Route::middleware([ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
        ->prefix(LaravelLocalization::setLocale())
        ->group(base_path('routes/web.php'));
}

    
    }

