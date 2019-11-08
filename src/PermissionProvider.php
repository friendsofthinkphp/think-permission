<?php
namespace xiaodi\Permission;

use xiaodi\Permission\Contract\UserContract as UserInterface;

class PermissionProvider
{
    protected $user;

    protected $config = [
        'auth_super_id'     => 1,
    
        'models' => [
            'user' => \xiaodi\Permission\Models\User::class,

            'role' => \xiaodi\Permission\Models\Role::class,

            'has_permission' => \xiaodi\Permission\Models\HasPermissionAccess::class,

            'permission' => \xiaodi\Permission\Models\Permission::class
        ],

        'tables' => [
            // 用户表
            'user' => 'auth_user',
            
            // 角色表
            'role' => 'auth_role',

            // 规则表
            'permission' => 'auth_permission',

            // 权限多态关联表(可以分别获取用户、角色的权限)
            'has_permission' => 'auth_has_permission',

            // 角色与规则表 多对多 中间表
            'role_permission_access' => 'auth_role_permission_access',

            // 用户与角色 多对多 中间表
            'user_role_access' => 'auth_user_role_access'
        ]
    ];

    public function __construct()
    {
    }

    public function user(UserInterface $user)
    {
        $this->user = $user;
        return $this->user;
    }
}
