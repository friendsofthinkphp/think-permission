<?php

namespace xiaodi\Permission\Contract;

interface UserContract
{
    public function can($permission);

    /**
     * 将用户分配到指定角色
     *
     * @return void
     */
    public function assignRole($role);

    /**
     * 删除指定角色
     *
     * @param [type] $role
     * @return void
     */
    public function removeRole($role);
}
