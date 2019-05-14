<?php
namespace xiaodi\Permission\Contract;

use think\model\relation\BelongsToMany;

interface Role
{
    public function users():belongsToMany;

    public function permissions();

    public function findById(int $id);

    public function findByName(string $name);

}