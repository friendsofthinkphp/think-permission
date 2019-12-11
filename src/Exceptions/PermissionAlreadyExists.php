<?php

namespace xiaodi\Permission\Exceptions;

use InvalidArgumentException;

class PermissionAlreadyExists extends InvalidArgumentException
{
    public static function create(string $permissionName)
    {
        return new static("此 `{$permissionName}` 已存在数据表中.");
    }
}
