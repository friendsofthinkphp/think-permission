<?php

namespace xiaodi\Permission\Middleware;

class Permission
{
    public function handle($request, \Closure $next, $permissions)
    {
        // app('Permission')->user()->can('role-add');
        return $next($request);
    }
}
