<?php
namespace xiaodi\Permission\Validate;

use think\Validate;

/**
 * 角色验证类
 *
 */
class Role extends Validate
{
    protected $rule = [
        'id'      =>  'require',
        'title'   =>  'require',
        'rules'    =>  'require',
    ];

    protected $message  =   [
        'id.require'    => '标识必须',
        'title.require' => '名称必须',
        'rules.require'  => '规则必须',
    ];

    protected $scene = [
        'update'  =>  ['title', 'id'],
        'create'  =>  ['title', 'rules'],
        'delete'  =>  ['id']
    ];
}
