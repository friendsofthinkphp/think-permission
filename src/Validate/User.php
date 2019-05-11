<?php
namespace xiaodi\Permission\Validate;

use think\Validate;

/**
 * 后台用户验证类
 */
class User extends Validate
{
    protected $rule = [
        'admin_user'      =>  'require',
        'admin_password'   =>  'require',
        'roles'   =>  'require',
    ];

    protected $message  =   [
        'admin_user.require'    => '账号必须',
        'admin_user.unique' => '账号重复',
        'admin_password.require' => '密码必须',
        'roles.require' => '角色必须',
    ];

    protected $scene = [
        'edit'    =>  ['admin_user', 'roles', 'admin_id'],
        'create'  =>  ['admin_user', 'admin_password', 'roles'],
        'delete'  =>  ['admin_id']
    ];
}
