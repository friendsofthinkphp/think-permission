<?php

namespace xiaodi\Permission\Contract;

use think\Request;
use think\Response;

interface RoleMiddlewareContract
{
    /**
     * 检查是否有权限.
     *
     * @param Request      $request
     * @param UserContract $user
     * @param string       $role
     *
     * @return void
     */
    public function requestHasRole(Request $request, UserContract $user, string $role);

    /**
     * 用户没有权限.
     *
     * @param Request $request
     *
     * @return void
     */
    public function handleNoAuthority(Request $request): Response;

    /**
     * 用户未登录.
     *
     * @param Request $request
     *
     * @return void
     */
    public function handleNotLoggedIn(Request $request): Response;
}
