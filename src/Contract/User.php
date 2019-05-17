<?php
namespace xiaodi\Permission\Contract;

use think\model\relation\BelongsToMany;

interface User
{
    /**
     * 实现多对多的角色关系
     *
     * @return BelongsToMany
     */

    public function roles():BelongsToMany;

    /**
     * 通过id获取详情
     *
     * @param integer $id
     * @return void
     */
    public function getById(int $id);

    /**
     * 通过name获取详情
     *
     * @param string $name
     * @return void
     */
    public function getByName(string $name);
}