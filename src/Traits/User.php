<?php

namespace xiaodi\Permission\Traits;

use think\Collection;
use xiaodi\Permission\Model\Permission;
use xiaodi\Permission\Contract\RoleContract;
use think\model\relation\BelongsToMany;

trait User
{
    /**
     * 获取用户下所有角色.
     *
     * @return void
     */
    public function roles(): BelongsToMany
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
     * 获取用户.
     *
     * @param string $name
     *
     * @return void
     */
    public static function findByName($name)
    {
        return self::where(['name' => $name])->find();
    }

    /**
     * 是否超级管理员.
     *
     * @return bool
     */
    public function isSuper()
    {
        return $this->id == config('permission.super_id');
    }

    /**
     * 获取用户权限（所属分组）.
     *
     * @return void
     */
    public function getAllPermissions(): Collection
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            $permissions = array_unique(array_merge($permissions, $role->permissions->column('id')));
        }

        $permissions = Permission::whereIn('id', implode(',', $permissions))->select();

        return $permissions;
    }
}
