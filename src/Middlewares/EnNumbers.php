<?php
namespace Majazeh\Dashboard\Middlewares;

use Closure;
class EnNumbers
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
?>