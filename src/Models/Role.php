<?php
namespace xiaodi\Permission\Models;

use think\Model;

use think\model\relation\BelongsToMany;
use xiaodi\Permission\Traits\HasRoles;
use xiaodi\Permission\Traits\HasPermissions;
use xiaodi\Permission\Contract\Role as RoleContract;

/**
 * 角色模型
 * 
 */
class Role extends Model implements RoleContract
{
    use HasRoles;
    use HasPermissions;

    public function __construct($data = [])
    {
        $prefix = config('database.prefix');
        $name = config('permission.tables.role');
        $table = [$prefix, $name];

        $this->pk = 'id';
        $this->table = implode('', $table);

        parent::__construct($data);
    }

    /**
     * 通过id获取详情
     *
     * @param integer $id
     * @return void
     */
    public function findById(int $id)
    {
        $res = $this->get($id);
        return $res;
    }

    /**
     * 通过name获取详情
     *
     * @param string $name
     * @return void
     */
    public function findByName(string $name)
    {
        $res = $this->get([
            'name' => $name
        ]);
        
        return $res;
    }
}
