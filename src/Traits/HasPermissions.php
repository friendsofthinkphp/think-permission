<?php
namespace xiaodi\Permission\Traits;

use xiaodi\Permission\Models\Permission;
use xiaodi\Permission\Exceptions\PermissionAlreadyExists;

trait HasPermissions
{

    /**
     * 获取(用户直接，角色)分配的权限
     *
     * @return void
     */
    public function permissions()
    {
        return $this->morphMany(config('permission.models.has_permission'), 'model');
    }

    /**
     * 获取用户所有权限
     *
     * @return void
     */
    public function getAllPermissions()
    {
        // 获取直接分配给用户的权限
        $userPermissions = $this->permissions;

        if ($this->roles) {
            // 获取用户所属角色的权限
            foreach($this->roles as $role)
            {
                $userPermissions = $userPermissions->merge($role->permissions);
            }
        }

        return $userPermissions;
    }
    
    /**
     * 用户、角色添加权限
     *
     * @param [type] ...$data
     * @return void
     */
    public function givePermissionTo(...$data)
    {
        $exists = array_column($this->permissions->toArray(), 'content');

        $permissions = [];
        foreach($data as $permission) {
            if (in_array($permission, $exists)) {
                throw PermissionAlreadyExists::create($permission);
            }

            $permissions[] = ['content' => $permission];

        }
 
        if (!empty($permission)) {
            $this->permissions()->saveAll($permissions);
        }

    }

    /**
     * 判断用户是否有此权限
     *
     * @param [type] $name
     * @return boolean
     */
    public function can(stirng $name)
    {
        $permissions = array_column($this->getAllPermissions()->toArray(), 'content');
        
        return in_array($name, $permissions);
    }

    /**
     * 获取指定权限的用户
     *
     * @param [type] $name
     * @return void
     */
    public static function permission(string $name)
    {
        return (new self())->permissions()->where('content', $name);
    }

}