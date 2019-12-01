<?php

namespace xiaodi\Permission\Traits;

use xiaodi\Permission\Model\Role;
use xiaodi\Permission\Contract\RoleContract;

trait Permission
{
    /**
     * 获取权限所有的角色列表.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            \xiaodi\Permission\Model\Role::class,
            \xiaodi\Permission\Model\RolePermissionAccess::class,
            'role_id',
            'permission_id'
        );
    }

    /**
     * 将当前权限分配到指定角色.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function assignRole(RoleContract $role)
    {
        $this->roles()->attach($role);
    }

    /**
     * 移除已分配的角色.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function removeRole(RoleContract $role)
    {
        $this->roles()->detach($role);
    }

    /**
     * 通过名称查找规则.
     */
    public static function findByName($name)
    {
        return self::where(['name' => $name])->find();
    }
}
