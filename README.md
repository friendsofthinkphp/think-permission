# ThinkPHP Permission
ThinkPHP6 权限包

[![Latest Stable Version](https://poser.pugx.org/xiaodi/think-permission/v/stable)](https://packagist.org/packages/xiaodi/think-permission)
[![Total Downloads](https://poser.pugx.org/xiaodi/think-permission/downloads)](https://packagist.org/packages/xiaodi/think-permission)
[![Latest Unstable Version](https://poser.pugx.org/xiaodi/think-permission/v/unstable)](//packagist.org/packages/xiaodi/think-permission)
[![LICENSE](https://img.shields.io/badge/license-Anti%20996-blue.svg)](https://github.com/996icu/996.ICU/blob/master/LICENSE)

### 安装
```
composer require xiaodi/think-permission:dev-master
```

### 使用
* [创建必要数据](#创建必要数据)
* * [规则](#规则)
* * [角色](#角色)
* * [用户](#用户)
* [分配关系](#分配关系)
* * [规则与角色](#规则与角色)
* * [用户与角色](#用户与角色)
* [解除关系](#解除关系)
* * [规则与角色](#解除规则与角色)
* * [用户与角色](#解除用户与角色)
* [权限判断](#权限判断)

### 创建必要数据
#### 规则
```php
use xiaodi\Permission\Model\Permission;
// 创建一条可查看首页的权限 
Permission::create(['name' => 'home']);
```

#### 角色
```php
use xiaodi\Permission\Model\Role;
// 创建一个名为编辑的角色
Role::create(['name' => 'writer']);
```

#### 用户
```php
use xiaodi\Permission\Model\User;
// 创建一个名为xiaodi的用户
User::create(['name' => 'xiaodi']);
```

### 分配关系
#### 规则与角色
```php

use xiaodi\Permission\Model\Permission;
use xiaodi\Permission\Model\Role;
// 将home规则分配到writer角色 
$permission = Permission::findByName('home');
$role = Permission::findByName('writer');
$permission->assignRole($role);

// 将home规则分配到writer角色 (跟上面效果一样)
$permission = Permission::findByName('home');
$role = Permission::findByName('writer');
$role->assignPermission($permission);
```

#### 用户与角色
```php

use xiaodi\Permission\Model\User;
use xiaodi\Permission\Model\Role;

// 为用户xiaodi分配 writer角色 
$user = User::findByName('xiaodi');
$role = Permission::findByName('writer');
$user->assignRole($role);

// 为用户xiaodi分配 writer角色 (跟上面效果一样)
$user = User::findByName('xiaodi');
$role = Permission::findByName('writer');
$role->assignUser($user);

```

### 解除关系
#### 解除规则与角色
```php
use xiaodi\Permission\Model\Permission;
use xiaodi\Permission\Model\Role;

// home规则与writer角色 解除关系
$permission = Permission::findByName('home');
$role = Permission::findByName('writer');
$permission->removeRole($role);

// writer角色与home规则 解除关系(跟上面效果一样)
$permission = Permission::findByName('home');
$role = Permission::findByName('writer');
$role->removePermission($permission);
```

#### 解除用户与角色
```php

use xiaodi\Permission\Model\User;
use xiaodi\Permission\Model\Role;

// 用户xiaodi与writer角色 解除关系
$user = User::findByName('xiaodi');
$role = Permission::findByName('writer');
$user->removeRole($role);

// writer角色与用户xiaodi 解除关系 (跟上面效果一样)
$user = User::findByName('xiaodi');
$role = Permission::findByName('writer');
$role->removeUser($user);

```

### 权限判断
```php
use xiaodi\Permission\Model\User;

$user = User::findByName('xiaodi');
if ($user->can('home')) {
    // 有 `home`权限
} else {
    // 无 `home`权限
}
```