<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
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
        // Explicitly load routes/api.php manually
        Route::prefix('api') // Adds the '/api' prefix
        ->middleware('api') // Group routes with API middleware
        ->group(base_path('routes/api.php'));

    }
}
