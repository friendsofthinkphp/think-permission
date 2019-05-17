<?php
namespace xiaodi\Permission\Exceptions;

use InvalidArgumentException;

class UnauthorizedException extends InvalidArgumentException
{
    public static function create(string $permissionName)
    {
        return new static("访问出错，你没有此 `{$permissionName}` 权限.");
    }
}