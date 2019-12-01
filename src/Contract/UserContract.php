<?php

namespace xiaodi\Permission\Contract;

interface UserContract
{
    public function can($permission);

    /**
     * 将用户分配到指定角色.
     *
     * @param \xiaodi\Permission\Contract\RoleContract $role
     *
     * @return void
     */
    public function assignRole(RoleContract $role);

    /**
     * 删除指定角色.
     *
     * @param \xiaodi\Permission\Contract\RoleContract $role
     *
     * @return void
     */
    public function removeRole(RoleContract $role);

    /**
     * 按名称查找用户.
     *
     * @param string $name
     *
     * @return void
     */
    public static function findByName($name);
}
