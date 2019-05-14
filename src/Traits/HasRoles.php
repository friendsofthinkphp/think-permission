<?php
namespace xiaodi\Permission\Traits;

use think\model\relation\BelongsToMany;

/**
 * 角色复用
 * 
 */
trait HasRoles
{
    /**
     * 获取用户所有的角色
     *
     * @return BelongsToMany
     */
    public function roles():BelongsToMany
    {
        $roles = $this->belongsToMany(
            config('permission.models.role'),
            config('permission.models.role_access')
        );

        return $roles;
    }

    /**
     * 获取当前角色下的所有用户
     *
     * @return void
     */
    public function users(): belongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.user'),
            config('permission.models.role_access')
        );
    }
}