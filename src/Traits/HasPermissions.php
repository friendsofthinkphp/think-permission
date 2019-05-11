<?php
namespace xiaodi\Permission\Traits;

use think\model\Collection;
use think\model\relation\BelongsToMany;
use xiaodi\Permission\Models\Permission;

trait HasPermissions
{

    /**
     * 获取多对多关联对象
     * 调用 $user->permissions
     * 
     * @return BelongsToMany
     */
    public function getPermissionsAttr(): BelongsToMany
    {
        $permissions = $this->belongsToMany(
            "xiaodi\\Permission\\Models\\Role",
            "xiaodi\\Permission\\Models\\RoleAccess"
        );

        return $permissions;
    }

    /**
     * 获取用户所在角色的所有权限
     * 调用 $user->getAllPermissions()
     * 
     * @return void
     */
    public function getAllPermissions(): Array
    {
        if ($this->admin_id === config('permission.auth_super_id')) {
            return $this->getPermissions();
        }

        $data = $this->permissions->select();

        $permissions = [];
        foreach($data as $item) {
            $rules = explode(',', $item->rules);
            $permissions = array_merge($permissions, $rules);
        }

        $permissions = array_unique($permissions);
        return $permissions;
    }

    /**
     * 获取所有规则列表
     *
     * @return void
     */
    protected function getPermissions()
    {
        return (new Permission)->where('pid', '<>', 0)->column('id');
    }

    /**
     * 获取用户所有角色列表
     * 调用 $user->getRoleNames()
     * 
     * @return void
     */
    public function getRoleNames(): Collection
    {
        $permissions = $this->permissions;

        return $permissions->select();
    }


    /**
     * 验证是否有些权限
     *
     * @param [type] $path
     * @return boolean
     */
    public function can($path)
    {
        $permissions = $this->getAllPermissions();
        $rules = (new Permission)->where('id', 'in', $permissions)->column('name');

        return in_array($path, $rules);
    }
}