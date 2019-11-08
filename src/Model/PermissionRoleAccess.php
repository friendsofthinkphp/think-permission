<?php

namespace xiaodi\Permission\Model;

use think\model\Pivot;

/**
 * 权限与角色中间表.
 */
class PermissionRoleAccess extends Pivot
{

    public function __construct($data = [])
    {
        $this->name = config('permission.role_permission_access.model');

        parent::__construct($data);   
    }
}