<?php

namespace xiaodi\Permission;

use think\App;
use xiaodi\Permission\Contract\PermissionHandleContract;

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
