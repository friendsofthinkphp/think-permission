<?php

namespace xiaodi\Permission;

use think\App;
use xiaodi\Permission\Contract\PermissionHandleContract;
use xiaodi\Permission\Contract\UserContract;

class Permission
{
    private $app;

    private $config;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->config = config('permission');
    }

    public function user()
    {
        if (!$this->app->user) {
            throw new \Exception('没有注入用户模型');
        }

        if (false === $this->app->user instanceof UserContract) {
            throw new \Exception('not implement xiaodi\Permission\Contract\UserContract');
        }

        return $this->app->user;
    }

    public function handleMiddleware()
    {
        $className = $this->config['middleware'];

        if (!$className) {
            throw new \Exception('没有配置权限中间件');
        }

        $handle = new $className();
        if (false === $handle instanceof PermissionHandleContract) {
            throw new \Exception('not implements \xiaodi\Permission\Contract\PermissionHandleContract');
        }

        return $handle;
    }
}
