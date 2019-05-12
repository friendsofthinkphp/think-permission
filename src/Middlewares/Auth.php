<?php
namespace xiaodi\Permission\Middlewares;

/**
 * 权限验证中间件
 * 
 */
class Auth
{
    public function handle($request, \Closure $next)
    {
        $user = app('Permission')->user();

        $path = $request->routeInfo()['route'];
        if (false == $user->can($path)) {
            return response(['code' => 50015, 'message' => '没有操作权限！'], 401, [], 'json');
        }
        
        return $next($request);
    }
}
