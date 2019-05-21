<?php
namespace Majazeh\Dashboard;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class MajazehDashboardRouteProvider extends ServiceProvider
{
    protected $middleware = [
        'en_numbers' => Middlewares\EnNumbers::class
    ];

    public function boot(Router $router)
    {
        parent::boot($router);

        foreach($this->middleware as $name => $class) {
            $this->middleware($name, $class);
        }
    }
}
?>