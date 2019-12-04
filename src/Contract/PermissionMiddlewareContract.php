<?php

namespace xiaodi\Permission\Contract;

use think\Request;
use think\Response;
use xiaodi\Permission\Contract\UserContract;

interface PermissionMiddlewareContract
{
    /**
     * 检查是否有权限
     *
     * @param Request $request
     * @param UserContract $user
     * @param [type] $permission
     * @return void
     */
    public function requestHasPermission(Request $request, UserContract $user, $permission);


    /**
     * 用户没有权限
     *
     * @param Request $request
     * @return void
     */
    public function handleNoAuthority(Request $request): Response;

    /**
     * 用户未登录
     *
     * @param Request $request
     * @return void
     */
    public function handleNotLoggedIn(Request $request): Response;
}
