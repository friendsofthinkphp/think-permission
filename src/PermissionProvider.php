<?php

namespace xiaodi\Permission;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use think\facade\Config;
use xiaodi\Permission\Models\User;

class PermissionProvider
{
    protected $user;

    protected $request;

    protected $config = [
        'auth_super_id'     => 1,

        'models' => [
            'user' => \xiaodi\Permission\Models\User::class,

            'role' => \xiaodi\Permission\Models\Role::class,

            'has_permission' => \xiaodi\Permission\Models\HasPermissionAccess::class,

            'permission' => \xiaodi\Permission\Models\Permission::class,
        ],

        'tables' => [
            // 用户表
            'user' => 'auth_user',

            // 角色表
            'role' => 'auth_role',

            // 规则表
            'permission' => 'auth_permission',

            // 权限多态关联表(可以分别获取用户、角色的权限)
            'has_permission' => 'auth_has_permission',

            // 角色与规则表 多对多 中间表
            'role_permission_access' => 'auth_role_permission_access',

            // 用户与角色 多对多 中间表
            'user_role_access' => 'auth_user_role_access',
        ],

        'validate' => [
            'type' => '1',      // 认证方式 1: Jwt-token；2: Session
            'jwt'  => [
                'header' => 'authorization',
                'key'    => 'uid',  // 签发参数 claim
            ],
            'session' => [
                'key' => 'uid',  // session name
            ],
        ],
    ];

    public function __construct()
    {
        // todo
        if (null != config('permission.')) {
            $config = config('permission.');
            $this->config = array_merge($this->config, $config);
        }

        $this->request = request();
    }

    public function user()
    {
        return $this->getUser();
    }

    protected function getConfig($type)
    {
        return $this->config[$type];
    }

    protected function getUser()
    {
        $config = $this->getConfig('validate');
        if ($config['type'] == 1) {
            $uid = $this->getUserIdByToken();
        } elseif ($config['type'] == 2) {
            $uid = $this->getUserIdBySession();
        }

        $class = $this->config['models']['user'];
        $model = new $class();
        $this->user = $model->getById($uid);

        return $this->user;
    }

    protected function getUserIdBySession()
    {
        // todo
        return 1;
    }

    protected function getUserIdByToken()
    {
        // $config = $this->getConfig('validate')['jwt'];
        // $name = $config['header'];
        // $key = $config['key'];

        // $token = $this->request->header($name);
        // if (empty($token)) {
        //     // 缺少Token.
        //     exception('Require Token', 50001);
        // }

        $key = 'uid';
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.eyJpYXQiOjE1NTc4MDI3NjMsImV4cCI6MTU1ODA2MTk2MywidWlkIjoxfQ.';
        $token = (new Parser())->parse((string) $token);
        $data = new ValidationData();
        if (!$token->validate($data)) {
            // Token过期.
            exception('Expired Token', 50002);
        }

        if (empty($uid = $token->getClaim($key))) {
            // 缺少签发参数.
            exception('Require Claim', 50003);
        }

        return $uid;
    }
}
