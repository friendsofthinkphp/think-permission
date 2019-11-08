<?php

namespace xiaodi\Permission\Model;

use think\Model;
use xiaodi\Permission\Model\Permission;
use xiaodi\Permission\Contract\RoleContract;

class Role extends Model implements RoleContract
{
    public function __construct($data = [])
    {
        $this->name = config('permission.role.table');

        parent::__construct($data);
    }

    /**
     * 获取角色下所有权限
     *
     * @return void
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('permission.permission.model'),
            config('permission.role_permission_access.model'),
            'permission_id',
            'role_id'
        );
    }

    /**
     * 为当前角色分配一个权限
     *
     * @param [type] $permission
     * @return void
     */
    public function assignPermission($permission)
    {
        $permission = Permission::get(['name' => $permission]);
        $this->permissions()->attach($permission);
    }

    /**
     * 为当前角色移除一个权限
     *
     * @param [type] $permission
     * @return void
     */
    public function removePermission($permission)
    {
        $permission = Permission::get(['name' => $permission]);
        $this->permissions()->detach($permission);
    }
}
