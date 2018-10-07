<?php

namespace Majazeh\Dashboard;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;

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
        if(file_exists(base_path('routes/dashboard.php')))
        {
            require base_path('routes/dashboard.php');
        }
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        View::addLocation(__DIR__.'/views');
        $this->loadTranslationsFrom( __DIR__.'/lang', 'dashio');
        if(\Request::segment(1) == 'api')
        {
            $this->app->bind(
                \Illuminate\Contracts\Debug\ExceptionHandler::class,
                MajazehException::class
            );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias('Data', Controllers\Data::class);
        });
    }
}
