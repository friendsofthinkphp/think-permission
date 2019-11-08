<?php

namespace xiaodi\Permission\Contract;

interface RoleContract
{
    /**
     * 获取角色下所有权限
     *
     * @return void
     */
    public function permissions();

    /**
     * 为当前角色分配一个权限
     *
     * @param [type] $permission
     * @return void
     */
    public function assignPermission($permission);

    /**
     * 为当前角色移除一个权限
     *
     * @param [type] $permission
     * @return void
     */
    public function removePermission($permission);
}
