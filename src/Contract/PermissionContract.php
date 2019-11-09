<?php

namespace xiaodi\Permission\Contract;

interface PermissionContract
{
    /**
     * 获取有此权限的角色列表.
     *
     * @return void
     */
    public function roles();

    /**
     * 将当前权限分配到指定角色.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function assignRole($role);

    /**
     * 把当前权限移除到指定角色.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function removeRole($role);
}
