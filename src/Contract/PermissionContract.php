<?php

namespace xiaodi\Permission\Contract;

use xiaodi\Permission\Contract\RoleContract;

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
    public function assignRole(RoleContract $role);

    /**
     * 把当前权限移除指定角色.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function removeRole(RoleContract $role);

    /**
     * 通过名称查找规则.
     */
    public static function findByName($name);
}
