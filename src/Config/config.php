<?php

use xiaodi\Permission\Model\Permission;
use xiaodi\Permission\Model\PermissionRoleAccess;
use xiaodi\Permission\Model\Role;
use xiaodi\Permission\Model\User;
use xiaodi\Permission\Model\UserRoleAccess;

return [
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
