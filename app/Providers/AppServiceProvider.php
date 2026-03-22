<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\Incidencia;
use App\Policies\IncidenciaPolicy;

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
    
    public function boot()
{
    // Registrar la política para el modelo Incidencia
    Gate::policy(Incidencia::class, IncidenciaPolicy::class);
}
}
