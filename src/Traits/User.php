<?php

namespace xiaodi\Permission\Traits;

use xiaodi\Permission\Contract\RoleContract;
use xiaodi\Permission\Contract\UserContract;

trait User
{
    /**
     * 获取用户下所有角色.
     *
     * @return void
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('permission.role.model'),
            config('permission.user_role_access'),
            config('permission.role.froeign_key'),
            config('permission.user.froeign_key')
        );
    }

    /**
     * 将用户分配到指定角色.
     *
     * @return void
     */
    public function assignRole(RoleContract $role)
    {
        $this->roles()->save($role);
    }

    /**
     * 删除指定角色.
     *
     * @param [type] $role
     *
     * @return void
     */
    public function removeRole(RoleContract $role)
    {
        $this->roles()->detach($role);
    }

    public function assignUser(UserContract $user)
    {
        $this->users()->detach($user);
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

    /**
     * 获取用户
     *
     * @param string $name
     * @return void
     */
    public static function findByName($name)
    {
        return self::where(['name' => $name])->find();
    }

    /**
     * 是否超级管理员
     *
     * @return boolean
     */
    public function isSuper()
    {
        return $this->id == config('permission.super_id');
    }
}
