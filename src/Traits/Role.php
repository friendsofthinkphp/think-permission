<?php

namespace xiaodi\Permission\Traits;

use xiaodi\Permission\Contract\PermissionContract;
use xiaodi\Permission\Contract\UserContract;

trait Role
{
    /**
     * 获取角色下所有权限.
     *
     * @return void
     */
    public function permissions()
    {
        return $this->belongsToMany(
            \xiaodi\Permission\Model\Permission::class,
            \xiaodi\Permission\Model\RolePermissionAccess::class,
            'permission_id',
            'role_id'
        );
    }

    /**
     * 获取角色下所有用户.
     *
     * @return void
     */
    public function users()
    {
        return $this->belongsToMany(
            \xiaodi\Permission\Model\User::class,
            \xiaodi\Permission\Model\UserRoleAccess::class,
            'user_id',
            'role_id'
        );
    }

    /**
     * 为当前角色分配一个权限.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function assignPermission(PermissionContract $permission)
    {
        $this->permissions()->attach($permission);
    }

    /**
     * 为当前角色移除一个权限.
     *
     * @param [type] $permission
     *
     * @return void
     */
    public function removePermission(PermissionContract $permission)
    {
        $this->permissions()->detach($permission);
    }

    /**
     * 将当前角色分配到指定用户.
     *
     * @param \xiaodi\Permission\Contract\UserContract $user
     *
     * @return void
     */
    public function assignUser(UserContract $user)
    {
        $this->users()->attach($user);
    }

    /**
     * 角色与用户解除关系.
     *
     * @param \xiaodi\Permission\Contract\PermissionContract $user
     *
     * @return void
     */
    public function removeUser(UserContract $user)
    {
        $this->users()->detach($user);
    }

    /**
     * 通过名称查找角色.
     *
     * @param string $name
     */
    public static function findByName($name)
    {
        return self::where(['name' => $name])->find();
    }
}
