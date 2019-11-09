<?php

namespace xiaodi\Permission\Model;

use think\model\Pivot;

/**
 * 用户与角色中间表.
 */
class UserRoleAccess extends Pivot
{
    public function __construct($data = [])
    {
        $this->name = config('permission.user_role_access.table');

        parent::__construct($data);
    }
}
