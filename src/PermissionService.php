<?php

namespace xiaodi\Permission;

use xiaodi\Permission\Middleware\Permission;

class PermissionService extends \think\Service
{
    public function register()
    {
        $this->app->bind('auth', Permission::class);
    }

    public function boot()
    {
        // TODO
    }
}
