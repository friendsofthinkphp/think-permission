<?php
namespace xiaodi\Permission\Contract;

interface Permission
{
    public function findById(int $id);

    public function findByName(string $name);
}