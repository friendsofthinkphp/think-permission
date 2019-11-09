<?php

namespace xiaodi\Permission\Model;

use think\Model;
use xiaodi\Permission\Contract\UserContract;

class User extends Model implements UserContract
{
    public function __construct($data = [])
    {
        $this->name = config('permission.user.table');

        parent::__construct($data);
    }

    public function permissions()
    {
        return $this->morphMany('HasPermissionAccess', 'model');
    }

    /**
     * 获取用户下所有角色.
     *
     * @return void
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('permission.role.model'),
            config('permission.user_role_access.model'),
            'role_id',
            'user_id'
        );
    }

    /**
     * 将用户分配到指定角色.
     *
     * @return void
     */
    public function assignRole($role)
    {
        $role = Role::get(['name' => $role]);
        $this->roles()->save($role);
    }

    /**
     * 删除指定角色.
     *
     * @param [type] $role
     *
     * @return void
     */
    public function removeRole($role)
    {
        $role = Role::get(['name' => $role]);
        $this->roles()->detach($role);
    }

    /**
     * 检查是否有此权限.
     *
     * @param [type] $permission
     *
     * @return bool
     */
    public function can($permission)
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            $permissions = array_merge(
                $permissions,
                array_column($role->permissions->toArray(), 'name')
            );
        }

        $permissions = array_unique($permissions);

        return in_array($permission, $permissions);
    }
}
