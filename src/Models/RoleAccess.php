<?php
namespace xiaodi\Permission\Models;

use think\model\Pivot;

/**
 * 中间表
 * 
 */
class RoleAccess extends Pivot
{
   public function __construct($data = [])
   {
      $prefix = config('database.prefix');
      $name = config('permission.tables.role_access');
      $table = [$prefix, $name];

      $this->table = implode('', $table);
      parent::__construct($data);
   }
   
}
