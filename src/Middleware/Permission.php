<?php

namespace xiaodi\Permission\Middleware;

class Permission
{
    public function handle($request, \Closure $next, $permissions)
    {
        // TODO
        return $next($request);
    }
}
