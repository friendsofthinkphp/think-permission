<?php

return [
    // 超级管理员id
    'auth_super_id' => 1,

    // 用户模型
    'user' => \xiaodi\Permission\Model\User::class,

    // 规则模型
    'permission' => \xiaodi\Permission\Model\Permission::class,

    // 角色模型
    'role' => \xiaodi\Permission\Model\Role::class,

    // 角色与规则中间表模型
    'role_permission_access' => \xiaodi\Permission\Model\RolePermissionAccess::class,

    // 用户与角色中间表模型
    'user_role_access' => \xiaodi\Permission\Model\UserRoleAccess::class,
];
