<?php

namespace xiaodi\Permission\Model;

use think\Model;
use xiaodi\Permission\Contract\PermissionContract;

class Permission extends Model implements PermissionContract
{
    public function __construct($data = [])
    {
        $this->name = config('permission.permission.table');

        parent::__construct($data);
    }

    /**
     * 获取权限所有的角色列表.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('permission.role.model'),
            config('permission.role_permission_access.model'),
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
    public function assignRole($role)
    {
        $role = Role::get(['name' => $role]);
        $this->roles()->attach($role);
    }

    /**
     * 移除已分配的角色.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function removeRole($role)
    {
        $role = Role::get(['name' => $role]);
        $this->roles()->detach($role);
    }
}
