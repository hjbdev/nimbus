<?php

namespace Hjbdev\Nimbus\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Access\Gate;

class Authorize
{
    public function __construct(protected Gate $gate)
    {
        //
    }

    public function handle($request, Closure $next)
    {
        $this->gate->authorize('viewNimbus');

        return $next($request);
    }
}
