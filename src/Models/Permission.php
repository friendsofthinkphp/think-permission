<?php
namespace xiaodi\Permission\Models;

use think\Model;
use think\model\relation\BelongsToMany;
use xiaodi\Permission\Contract\Permission as PermissionContract;

/**
 * 权限模型
 * 
 */
class Permission extends Model implements PermissionContract
{
    public function __construct($data = [])
    {
        $prefix = config('database.prefix');
        $name = config('permission.tables.permission');
        $table = [$prefix, $name];

        $this->pk = 'id';
        $this->table = implode('', $table);

        parent::__construct($data);
    }
    
    /**
     * 获取具有此权限的角色
     *
     * @return BelongsToMany
     */
    public function roles():BelongsToMany
    {
        $roles = $this->belongsToMany(
            config('permission.models.role'),
            config('permission.tables.role_permission_access'),
            'role_id',
            'permission_id'
        );

        return $roles;
    }

    /**
     * 将规则分配到角色
     *
     * @param [type] $roles
     * @return void
     */
    public function assignRole(...$roles)
    {
        $class = config('permission.models.role');
        $model = new $class;

        $roles = $model->where('name', 'in', $roles)->select();

        if (!empty($roles->toArray())) {
            // 同步配置到 规则、角色中间表
            $this->roles()->attach(array_column($roles->toArray(), 'id'));
            $permission = $this->toArray()['name'];

            // 插入到权限表
            foreach($roles as $role) {
                $role->givePermissionTo($permission);
            }
        }
    }

    /**
     * 删除角色权限
     *
     * @return void
     */
    public function removeRole(...$roles)
    {
        $class = config('permission.models.role');
        $model = new $class;

        $roles = $model->where('name', 'in', $roles)->select();

        // 同步删除 规则、角色中间表
        $this->roles()->detach($this->id);

        $name = $this->toArray()['name'];
        foreach($roles as $role) {
            $role->revokePermissionTo($name);
        }
    }

    public function getById(int $id)
    {
        return $this->get($id);
    }

    public function getByName(string $name)
    {
        return $this->get(['name' => $name]);
    }
}
