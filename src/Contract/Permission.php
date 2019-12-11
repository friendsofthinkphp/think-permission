<?php

namespace xiaodi\Permission\Contract;

interface Permission
{
    public function roles();

    public function getById(int $id);

    public function getByName(string $name);
}
