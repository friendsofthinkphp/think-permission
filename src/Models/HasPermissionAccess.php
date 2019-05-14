<?php
namespace xiaodi\Permission\Models;

use think\Model;

class HasPermissionAccess extends Model
{
    public function __construct($data = [])
    {
        $prefix = config('database.prefix');
        $name = config('permission.tables.has_permission');
        $table = [$prefix, $name];

        $this->table = implode('', $table);
        parent::__construct($data);
    }
}
