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
            \xiaodi\Permission\Model\Role::class,
            \xiaodi\Permission\Model\UserRoleAccess::class,
            'role_id',
            'user_id'
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

    public static function findByName($name)
    {
        return self::where(['name' => $name])->find();
    }
}
