# think-permission

### 安装
```
composer require xiaodi/think-permission
```

### 权限验证
#### 方式一 使用包自带的Model
```
<?php
use xiaodi/Permission/Models/User;

$uid = 1;
$user = (new User)->getInfo(1);
$user->can('path');
```

#### 方式二 创建一个Model 继承包对应的Model
```
<?php
namepsace app/path;

use xiaodi/Permission/Models/User as Model;

class User extends Model
{
  // 其它业务代码
}

$uid = 1;
$user = (new User)->getInfo(1);
$user->can('path');
```
