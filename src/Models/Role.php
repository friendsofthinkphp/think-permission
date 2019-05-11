<?php
namespace xiaodi\Permission\Models;

use think\Model;
use xiaodi\Permission\Validate\Role as Validate;

use xiaodi\Permission\Traits\HasPermissions;

/**
 * 角色模型
 * 
 */
class Role extends Model
{
    protected $table = 'pg_auth_group';

    protected $pk = 'id';

    /**
     * 数据验证
     * @param array $data
     * @param string $scene
     */
    public static function validate($data, $scene)
    {
        $validate = new Validate;

        if (!$validate->scene($scene)->check($data)) {
            exception($validate->getError());
        }
    }

    /**
     * 添加
     * @param array $data
     */
    public function add(array $data)
    {
        try {
            self::validate($data, 'create');
            $this->save($data);
        } catch (\Exception $e) {
            exception($e->getMessage());
        }
    }

    /**
     * 修改角色
     * @param array $data
     */
    public function edit($id, array $data)
    {
        try {
            $role = $this->getInfo($id);
            self::validate($data, 'update');
            $role->syncPermissions($data['rules']);
        } catch (\Exception $e) {
            exception($e->getMessage());
        }
    }

    /**
     * 角色权限（重新分配）
     *
     * @param [type] $permissions
     * @return void
     */
    public function syncPermissions($permissions)
    {
        $this->rules = implode(',', $permissions);
        $this->save();
    }

    /**
     * 角色权限（单独追加）
     *
     * @return void
     */
    public function givePermissionTo($permission)
    {
        $rules = $this->explode(',', $this->rules);
        if (!in_array($permission, $rules)) {
            array_unshift($rules, $permission);
            $this->rules = $rules;
            $this->save();
        }
    }

    /**
     * 角色权限（单独删除）
     *
     * @param [type] $permission
     * @return void
     */
    public function revokePermissionTo($permission)
    {
        $permissions = $this->explode(',', $this->rules);
        if (in_array($permission, $permissions)) {
            $res = array_keys($permissions, $permission);
            array_splice($permissions, $res[0], 1);

            $this->rules = implode(',', $permissions);
            $this->save();
        }
    }

    /**
     * 删除角色
     * @param string|int $id
     */
    public function deleteRole($id)
    {
        try {
            $info = $this->getInfo($id);
            $info->delete();
        } catch (\Exception $e) {
            exception($e->getMessage());
        }
    }

    /**
     * 获取角色详情
     * @param int|string $id
     *
     */
    public function getInfo($id)
    {
        $res = $this->getOrFail($id);

        return $res;
    }
}
