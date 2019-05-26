# ThinkPHP Permission
ThinkPHP5.1 权限包

[![Latest Stable Version](https://poser.pugx.org/xiaodi/think-permission/v/stable)](https://packagist.org/packages/xiaodi/think-permission)
[![Total Downloads](https://poser.pugx.org/xiaodi/think-permission/downloads)](https://packagist.org/packages/xiaodi/think-permission)
[![Latest Unstable Version](https://poser.pugx.org/xiaodi/think-permission/v/unstable)](//packagist.org/packages/xiaodi/think-permission)
[![LICENSE](https://img.shields.io/badge/license-Anti%20996-blue.svg)](https://github.com/996icu/996.ICU/blob/master/LICENSE)
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
    
    'models' => [
        'user' => \xiaodi\Permission\Models\User::class,

        'role' => \xiaodi\Permission\Models\Role::class,

        'has_permission' => \xiaodi\Permission\Models\HasPermissionAccess::class,

        'permission' => \xiaodi\Permission\Models\Permission::class
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
        'user_role_access' => 'auth_user_role_access'
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
```
### 权限验证
#### 注册容器(推荐)
注册容器后，你可以在程序任何地方使用  
模块或应用根目录 `provider.php`
```php
<?php

return [
    'Permission'      => \xiaodi\Permission\PermissionProvider::class,
];

```

控制器、Model、中间件中调用方法
```php
// 获取登录的用户对象
app('Permission')->user()

// 验证权限
app("Permission")->user()->can('action')
```

#### 路由中间件
```php
<?php

// 用户必须拥有 ·test-view· 访问权限
Route::rule('/test', 'admin/index/test', 'GET')
    ->middleware('\xiaodi\Permission\Middlewares\Permission', 'test-view');
```
#### 单独验证
方式一 使用包自带的Model
```php
<?php
use xiaodi/Permission/Models/User;

$uid = 1;
$user = (new User)->findById(1);

if (!$user->can('name')) {
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

### 例子

```
// 权限配置
// 创建规则
// dump(Permission::create(['name' => 'view']));

// 分配此权限给角色
// dump((new Permission)->getById(1)->assignRole('writer'));

// 获取拥有此权限的角色
// dump((new Permission)->getById(1)->roles);

// 删除已分配到角色的权限
// dump((new Permission)->getById(1)->removeRole('writer'));

// 角色配置
// 创建角色
// dump(Role::create(['name' => 'writer']));

// 获取角色下所有用户
// dump((new Role)->findById(1)->users);

// 获取角色分配的权限
// dump((new Role)->findById(1)->users);

// 分配角色权限
// dump((new Role)->findById(1)->givePermissionTo('rule-view'));


// 用户配置
// 创建用户
// dump(User::create(['name' => 'xiaodi']));

// 直接分配用户权限（不经过角色分配）
// dump((new User)->findById(1)->givePermissionTo('role-view'));

// 给用户分配角色
// dump((new User)->findById(1)->assignRole('writer'));

// 获取用户的角色
// dump((new User)->findById(1)->roles);

// 获取用户直接分配的权限
// dump((new User)->findById(1)->permissions);

// 获取用户所有权限
// dump((new User)->findById(1)->getAllPermissions());

// 判断用户是否有此权限
// dump((new User)->findById(1)->can('haha'));

// 获取拥有指定权限的用户
// dump(User::permission('haha')->select());
```
