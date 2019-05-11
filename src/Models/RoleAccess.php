<?php
namespace xiaodi\Permission\Models;

use think\model\Pivot;

/**
 * 中间表
 * 
 */
class RoleAccess extends Pivot
{

   protected $table = 'pg_auth_group_access';
   
}
