<?php

namespace Majazeh\Dashboard;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Request;
use Blade;

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

        Blade::directive('sort_icon', function($key) {
            $query = request()->all();
            $query['order'] = $key;
            $query['sort'] = 'asc';
            $asc = Request::create(url()->current(), 'GET', $query)->getUri();
            $query['sort'] = 'desc';
            $desc = Request::create(url()->current(), 'GET', $query)->getUri();
            return "<?php echo isset(\$_GET['order']) && strtolower(\$_GET['order']) == strtolower('$key') ? (isset(\$_GET['sort']) && strtolower(\$_GET['sort']) == 'asc' ? '<a href=\"'. order_link('$key', 'desc') .'\"><i class=\"fas text-primary fa-sort-up\"></i></a>' : '<a href=\"'. order_link('$key', 'asc') .'\"><i class=\"fas text-primary fa-sort-down\"></i></a>') : '<a href=\"'. order_link('$key', 'desc') .'\"><i class=\"fas fa-sort text-black-50\"></i></a>' ?>";
        });
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
