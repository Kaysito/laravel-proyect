<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- ¡OJO! No olvides importar esto

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
        // ESTE ES EL CODIGO QUE ARREGLA TU ERROR
        // Si estamos en producción (Render), obligamos a usar HTTPS
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}