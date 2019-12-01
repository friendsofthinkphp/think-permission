<?php

namespace xiaodi\Permission\Model;

use think\Model;
use xiaodi\Permission\Contract\PermissionContract;

/**
 * 权限.
 */
class Permission extends Model implements PermissionContract
{
    use \xiaodi\Permission\Traits\Permission;
}
