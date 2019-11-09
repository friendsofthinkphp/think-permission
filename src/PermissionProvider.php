<?php

namespace xiaodi\Permission;

use xiaodi\Permission\Contract\UserContract as UserInterface;
use xiaodi\Permission\Model\Permission;
use xiaodi\Permission\Model\PermissionRoleAccess;
use xiaodi\Permission\Model\Role;
use xiaodi\Permission\Model\User;
use xiaodi\Permission\Model\UserRoleAccess;

class PermissionProvider
{
    protected $user;

    protected $config = [
        'auth_super_id' => 1,

        'user' => [
            'table' => 'auth_user',
            'model' => User::class,
        ],

        'permission' => [
            'table' => 'auth_permission',
            'model' => Permission::class,
        ],

        'role' => [
            'table' => 'auth_role',
            'model' => Role::class,
        ],

        'role_permission_access' => [
            'table' => 'auth_role_permission_access',
            'model' => PermissionRoleAccess::class,
        ],

        'user_role_access' => [
            'table' => 'auth_user_role_access',
            'model' => UserRoleAccess::class,
        ],

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
