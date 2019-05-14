<?php
namespace xiaodi\Permission;

use xiaodi\Permission\Models\User;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use think\facade\Config;

class PermissionProvider
{
    protected $user;

    protected $request;

    protected $config = [
        'auth_super_id'     => 1,

        // 模型 可自行更换自己的 但必须要实现对应的接口
        'models' => [
            'user' => \xiaodi\Permission\Models\User::class,
    
            'role' => \xiaodi\Permission\Models\Role::class,
    
            'permission' => \xiaodi\Permission\Models\Permission::class
        ],
    
        // 引入数据表
        'tables' => [
            // 后台用户表
            'admin' => 'new_admin',
            
            // 角色表
            'role' => 'new_auth_role',
    
            // 规则表
            'permission' => 'new_auth_permission',
    
            // 中间表
            'role_access' => 'new_auth_role_access'
        ],
    
        'validate' => [
            'type' => '1',      // 认证方式 1: Jwt-token；2: Session
            'jwt' => [
                'header' => 'authorization',
                'key' => 'uid'  // 签发参数 claim 
            ],
            'session' => [
                'key' => 'uid'  // session name
            ]
        ]
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
        $config = $this->getConfig('validate')['jwt'];
        $name = $config['header'];
        $key = $config['key'];

        $token = $this->request->header($name);
        if (empty($token)) {
            // 缺少Token.
            exception('Require Token', 50001);
        }

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
