<?php

namespace Majazeh\Dashboard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;

class MajazehDashboardProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . "/assets" => public_path('/')]);

        require __DIR__.'/routes/web.php';
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        View::addLocation(__DIR__.'/views');
        $this->loadTranslationsFrom( __DIR__.'/lang', 'dashio');
        require_once('helpers.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
