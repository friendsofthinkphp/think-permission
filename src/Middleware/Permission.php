<?php

namespace xiaodi\Permission\Middleware;

use xiaodi\Permission\Permission as Ac;

/**
 * 权限中间件.
 */
final class Permission
{
    private $user;

    private $handle;

    public function __construct(Ac $permission)
    {
        $this->user = $permission->user();
        $this->handle = $permission->handleMiddleware();
    }

    public function handle($request, \Closure $next, $permission)
    {
        if (false === $this->user->can($permission)) {
            return $this->handle->handleNotAllow($permission);
        }

        // TODO
        return $next($request);
    }
}
