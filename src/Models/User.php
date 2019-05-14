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
        $table = config('permission.tables.admin');
        if ($prefix) {
            $table = implode('', [$prefix, $table]);
        }
        
        $this->table = $table;
        parent::__construct($data);
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
