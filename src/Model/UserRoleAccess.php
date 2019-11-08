<?php

namespace xiaodi\Permission\Model;

use think\model\Pivot;

/**
 * 用户与角色中间表
 */
class UserRoleAccess extends Pivot
{

    public function __construct($data = [])
    {
        $this->name = 'auth_user_role_access';

        parent::__construct($data);   
    }
}