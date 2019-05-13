# ThinkPHP5.1 权限认证
* Jwt Token  [lcobucci/jwt](https://github.com/lcobucci/jwt)
### 安装
```
composer require xiaodi/think-permission
```
### 配置
`config/permission.php`
```php
<?php
return [
    'auth_super_id'     => 1,
    'tables' => [
        // 后台用户表
        'admin' => 'admin',
        
        // 角色表
        'role' => 'auth_group',

        // 规则表
        'permission' => 'auth_rule',

        // 中间表
        'role_access' => 'auth_group_access'
    ]
];
```
### 权限验证
#### 注册容器(推荐)
注册容器后，你可以在程序任何地方使用  
模块或应用根目录 `provider.php`
```php
<?php

return [
    'Permission'      => \app\service\PermissionProvider::class,
];

```

控制器、Model、中间件中调用方法
```php
// 获取登录的用户对象
app('Permission')->user()

// 验证权限
app("Permission")->user()->can('path')
```

#### 配合中间件
模块或应用根目录 `middleware.php`
```php
<?php
return [
    "\\xiaodi\\Permission\\Middlewares\\Auth"
];
```
#### 单独验证
方式一 使用包自带的Model
```php
<?php
use xiaodi/Permission/Models/User;

$uid = 1;
$user = (new User)->getInfo(1);

if (!$user->can('path')) {
   // 没有权限
} 
```

创建一个Model 继承包对应的Model
```php
<?php
namepsace app/path;

use xiaodi/Permission/Models/User as Model;

class User extends Model
{
  // 其它业务代码
}

$uid = 1;
$user = (new User)->getInfo(1);
if (!$user->can('path')) {
   // 没有权限
} 
```

#### 生成Token
```php
<?php
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;

// 登录验证代码...
$uid = '登录之后，获取到的uid';

// 生成一个3天过期的Token
$token = (new Builder())
    ->setIssuedAt(time())
    ->setExpiration(time() + (86400 * 3))
    ->set('uid', $uid)
    ->getToken();

$token = (string) $token;
echo $token;
```

#### Sql
[数据表](https://github.com/xiaodit/think-admin/blob/master/sql/tables.sql)
