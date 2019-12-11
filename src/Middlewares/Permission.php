<?php

namespace xiaodi\Permission\Middlewares;

use xiaodi\Permission\Exceptions\UnauthorizedException;

/**
 * 权限验证中间件(验证规则专用).
 */
class Permission
{
    /**
     * 入口.
     *
     * @param [type]   $request
     * @param \Closure $next
     * @param [type]   $permissions 验证的规则
     *
     * @return void
     */
    public function handle($request, \Closure $next, $permissions)
    {
        $permissions = is_array($permissions) ? $permissions : \explode('|', $permissions);

        foreach ($permissions as $permission) {
            if (app('Permission')->user()->can($permission)) {
                return $next($request);
            }
        }

        throw UnauthorizedException::create($permission);
    }
}
