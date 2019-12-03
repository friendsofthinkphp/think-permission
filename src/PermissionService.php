<?php

namespace xiaodi\Permission;

class PermissionService extends \think\Service
{
    public function register()
    {
        $this->app->bind(Permission::class);
    }

    public function boot()
    {
        // TODO
    }
}
