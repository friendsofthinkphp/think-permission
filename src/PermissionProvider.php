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
        'type' => '1',      // 认证方式 1: Jwt-token；2: Session
        'jwt' => [
            'header' => 'authorization',
            'key' => 'uid'  // 签发参数 claim 
        ],
        'session' => [
            'key' => 'uid'  // session name
        ]
    ];

    public function __construct()
    {
        // todo
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
        if ($this->config['type'] == 1) {
            $uid = $this->getUserIdByToken();
        } elseif ($this->config['type'] == 2) {
            $uid = $this->getUserIdBySession();
        }

        $model = new User();
        $this->user = $model->getInfo($uid);

        return $this->user;
    }

    protected function getUserIdBySession()
    {
        // todo
        return 1;
    }

    protected function getUserIdByToken()
    {
        $config = $this->getConfig('jwt');
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
