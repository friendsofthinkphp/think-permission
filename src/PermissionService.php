<?php

namespace xiaodi\Permission;

use xiaodi\Permission\Middleware\Permission;
use xiaodi\Permission\Middleware\Role;

class PermissionService extends \think\Service
{
    public function register()
    {
        $this->app->bind('auth', Permission::class);
        $this->app->bind('auth.permission', Permission::class);
        $this->app->bind('auth.role', Role::class);
    }

    public function boot()
    {
        // TODO
    }
}
