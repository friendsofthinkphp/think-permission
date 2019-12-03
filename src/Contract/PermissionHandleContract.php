<?php

namespace xiaodi\Permission\Contract;

use think\Response;

interface PermissionHandleContract
{
    /**
     * 当没有权限时.
     *
     * @param string|array $permission 权限名称
     *
     * @return Response
     */
    public function handleNotAllow($permission): Response;
}
