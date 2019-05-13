<?php
namespace xiaodi\Permission\Validate;

use think\Validate;

/**
 * 后台用户验证类
 */
class User extends Validate
{
    protected $rule = [
        'user'      =>  'require',
        'password'   =>  'require',
        'roles'   =>  'require',
    ];

    protected $message  =   [
        'user.require'    => '账号必须',
        'user.unique' => '账号重复',
        'password.require' => '密码必须',
        'roles.require' => '角色必须',
    ];

    protected $scene = [
        'edit'    =>  ['user', 'roles', 'id'],
        'create'  =>  ['user', 'password', 'roles'],
        'delete'  =>  ['id']
    ];
}
