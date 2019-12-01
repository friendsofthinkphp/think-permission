<?php

namespace xiaodi\Permission\Model;

use think\Model;
use xiaodi\Permission\Contract\RoleContract;

/**
 * 角色
 */
class Role extends Model implements RoleContract
{
    use \xiaodi\Permission\Traits\Role;
}
