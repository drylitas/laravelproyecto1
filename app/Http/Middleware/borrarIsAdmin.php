<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

abstract class IsAdmin extends IsType
{
    public function handle($request, Closure $next)
    {
        return 'admin';
    }
}
