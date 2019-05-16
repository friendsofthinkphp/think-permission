<?php
namespace xiaodi\Permission\Models;

use think\Db;
use think\Model;
use xiaodi\Permission\Validate\User as Validate;
use xiaodi\Permission\Traits\HasRoles;
use xiaodi\Permission\Traits\HasPermissions;
use xiaodi\Permission\Contract\User as UserContract;
use think\model\relation\BelongsToMany;

class User extends Model implements UserContract
{
    use HasRoles;
    use HasPermissions;

    public function __construct($data = [])
    {
        $prefix = config('database.prefix');
        $table = config('permission.tables.user');
        if ($prefix) {
            $table = implode('', [$prefix, $table]);
        }
        
        $this->table = $table;
        parent::__construct($data);
    }

    /**
     * Undocumented function
     *
     * @param [type] $roles
     * @return void
     */
    public function assignRole($roles)
    {
        $class = config('permission.models.role');
        $model = new $class;

        $roles = $model->where('name', 'in', $roles)->select();

        if (!empty($roles->toArray())) {
            // 同步配置到 规则、角色中间表
            $this->roles()->attach(array_column($roles->toArray(), 'id'));
        }
    }

    public function findById(int $id)
    {
        $user = $this->get($id);

        return $user;
    }

    public function findByName(string $name)
    {
        $user = $this->get([
            'name' => $name
        ]);

        return $user;
    }
}
