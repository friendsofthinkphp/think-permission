<?php

namespace xiaodi\Permission\Traits;

use think\Collection;
use think\model\relation\BelongsToMany;
use xiaodi\Permission\Contract\RoleContract;
use xiaodi\Permission\Model\Permission;

trait User
{
    /**
     * 获取用户下所有角色.
     *
     * @return BelongsToMany
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
     * 删除所有已绑定的角色.
     *
     * @return void
     */
    public function removeAllRole()
    {
        $this->roles()->detach(
            $this->roles()->column('id')
        );
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
        if ($this->isSuper()) {
            return true;
        }

        $permissions = $this->getAllPermissions()->column('name');

        return in_array($permission, $permissions);
    }

    /**
     * 是否有此角色.
     *
     * @param string $role 角色名称
     *
     * @return bool
     */
    public function hasRole(string $role)
    {
        if ($this->isSuper()) {
            return true;
        }

        $roles = $this->roles->column('name');
        if (empty($roles) || !in_array($role, $roles)) {
            return false;
        }

        return true;
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
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        // 超级管理员 默认全部规则
        if ($this->isSuper()) {
            return Permission::select();
        }

        $permissions = [];

        foreach ($this->roles as $role) {
            $permissions = array_unique(array_merge($permissions, $role->permissions->column('name')));
        }

        $permissions = Permission::whereIn('name', implode(',', $permissions))->select();

        return $permissions;
    }
}
