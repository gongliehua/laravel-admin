<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 当前路由名称
        $currentRouteName = Route::currentRouteName();
        // 无需登录，无需鉴权 路由
        $noNeedLogin = config('admin.noNeedLogin');
        // 需要登录，无需鉴权 路由
        $noNeedRight = config('admin.noNeedRight');

        // 未登录状态下 || 登录状态下
        if (!getAdminAuth()->check()) {
            if (!in_array($currentRouteName, $noNeedLogin)) {
                return $request->ajax() ? response()->json(['code'=>401, 'data'=>[], 'msg'=>'请登录后操作']) : redirect()->route('admin.login');
            }
        } else {
            $isDefaultAdmin = getAdminAuth()->id() == 1 ? true : false;
            if (!$isDefaultAdmin || !in_array($currentRouteName, $noNeedRight)) {
                // 需要鉴权
            }
        }
        return $next($request);
    }
}
