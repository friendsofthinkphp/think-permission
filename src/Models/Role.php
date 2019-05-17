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

    public function access():BelongsToMany
    {
        $permissions = $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.tables.role_permission_access'),
            'permission_id',
            'role_id'
        );

        return $permissions;
    }

    /**
     * 获取(用户直接，角色)分配的权限
     *
     * @return void
     */
    public function permissions()
    {
        return $this->morphMany(
            config('permission.models.has_permission'),
            'model'
        );
    }

    /**
     * 删除角色所有权限
     *
     * @return void
     */
    public function revokeAllPermission()
    {
        $this->permissions()->where('model_id', $this->id)->delete();
        $this->access()->detach(
            $this->access()->column('permission_id')
        );
    }

    public function revokePermissionTo(string $name)
    {
        $this->permissions()->where('content', 'in', $name)->delete();
    }

    /**
     * 通过id获取详情
     *
     * @param integer $id
     * @return void
     */
    public function getById(int $id)
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
    public function getByName(string $name)
    {
        $res = $this->get([
            'name' => $name
        ]);
        
        return $res;
    }
}
