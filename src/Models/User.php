<?php
namespace xiaodi\Permission\Models;

use think\Db;
use think\Model;
use xiaodi\Permission\Validate\User as Validate;
use xiaodi\Permission\Traits\HasPermissions;

/**
 * 后台用户
 * 
 */
class User extends Model
{
    use HasPermissions;

    public function __construct($data = [])
    {
        $prefix = config('database.prefix');
        $name = config('permission.tables.admin');
        $table = [$prefix, $name];

        $this->pk = 'id';
        $this->table = implode('', $table);
        parent::__construct($data);
    }

    protected $autoWriteTimestamp = true;

    public function setAdminPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public function RoleAccess()
    {
        $permissions = $this->hasMany(
            "RoleAccess",
            "user_id"
        );

        return $permissions;
    }

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
     * 注册用户
     * @param array $data
     */
    public function addUser(array $data)
    {

        Db::startTrans();
        try {
            $roles = $data['roles'];
            self::validate($data, 'create');
            $this->save($data);

            foreach($roles as $role) {
                $data = ['role_id' => $role];
                $this->RoleAccess()->save($data);
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            exception($e->getMessage());
        }
    }

    /**
     * 修改用户
     * @param array $data
     */
    public function updateUser(int $id, array $data)
    {
        Db::startTrans();
        try {
            $user = $this->getInfo($id);

            self::validate($data, 'edit');

            // 重置密码
            if (isset($data['admin_password'])) {
                $user->admin_password = password_hash($data['admin_password'], PASSWORD_DEFAULT);
            }

            $user->save($data);

            // 删除角色重新分配
            $user->RoleAccess()->where('user_id', $user->id)->delete();

            $roles = $data['roles'];
            foreach($roles as $role) {
                $data = ['role_id' => $role];
                $user->RoleAccess()->save($data);
            }
            
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            exception($e->getMessage());
        }
    }

    /**
     * 删除用户
     * @param array $params
     */
    public function deleteUser($id)
    {
        Db::startTrans();
        try {

            if ($id == config('permission.auth_super_id')) {
                exception('操作出错');
            }

            $user = $this->getInfo($id);
            $user->RoleAccess()->where('user_id', $user->id)->delete();
            $user->delete();
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            exception($e->getMessage());
        }
    }

    /**
     * 获取用户信息
     * @param string|array $id
     */
    public function getInfo($map)
    {
        $user = $this->getOrFail($map);

        return $user;
    }
}
