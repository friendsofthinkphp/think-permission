<?php

namespace xiaodi\Permission\Model;

use think\Model;
use xiaodi\Permission\Contract\UserContract;

class User extends Model implements UserContract
{
    use \xiaodi\Permission\Traits\User;
}
