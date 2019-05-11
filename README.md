# think-permission

### 安装
```
composer require xiaodi/think-permission
```

### 权限验证
#### 中间件验证
```
<?php
namespace app\admin\middleware;

use app\service\models\User;
use think\facade\Config;

class CheckAuth
{
    public function handle($request, \Closure $next)
    {
        if ($request->controller() != 'Auth') {
          
          $uid = '';
          $user = (new User)->getInfo($uid);
          $pathInfo = dispatchPath();

          // 检测权限
          if (!$user->can($pathInfo)) {
              // 没有权限
          }
        }

        return $next($request);
    }
}

```
#### 单独验证
方式一 使用包自带的Model
```
<?php
use xiaodi/Permission/Models/User;

$uid = 1;
$user = (new User)->getInfo(1);
$user = (new User)->getInfo(1);

if (!$user->can('path')) {
   // 没有权限
} 
```

创建一个Model 继承包对应的Model
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
if (!$user->can('path')) {
   // 没有权限
} 
```
