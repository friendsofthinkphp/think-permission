<?php

namespace xiaodi\Permission\Contract;

use think\model\relation\BelongsToMany;

interface Role
{
    public function revokePermissionTo(string $name);

    public function users():belongsToMany;

    public function permissions();

    public function getById(int $id);

    public function getByName(string $name);
}
