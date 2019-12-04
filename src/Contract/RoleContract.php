<?php

namespace xiaodi\Permission\Contract;

use think\model\relation\BelongsToMany;

interface RoleContract
{
    /**
     * 获取角色下所有权限.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany;

    /**
     * 获取角色下所有用户.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany;

    /**
     * 为当前角色分配一个权限.
     *
     * @param \xiaodi\Permission\Contract\PermissionContract $permission
     *
     * @return void
     */
    public function assignPermission(PermissionContract $permission);

    /**
     * 为当前角色移除一个权限.
     *
     * @param \xiaodi\Permission\Contract\PermissionContract $permission
     *
     * @return void
     */
    public function removePermission(PermissionContract $permission);

    /**
     * 为当前角色移除所有权限.
     *
     * @return void
     */
    public function removeAllPermission();

    /**
     * 将当前角色分配到指定用户.
     *
     * @param \xiaodi\Permission\Contract\PermissionContract $user
     *
     * @return void
     */
    public function assignUser(UserContract $user);

    /**
     * 角色与用户解除关系.
     *
     * @param \xiaodi\Permission\Contract\PermissionContract $user
     *
     * @return void
     */
    public function removeUser(UserContract $user);

    /**
     * 通过名称查找角色.
     */
    public static function findByName($name);
}
