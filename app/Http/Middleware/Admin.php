<?php

namespace App\Http\Middleware;

use App\Models\AdminUser;
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

        // 未登录状态下 || 登录状态下(默认管理员是不受权限限制的)
        if (!getAdminAuth()->check()) {
            if (!in_array($currentRouteName, $noNeedLogin)) {
                return $request->ajax() ? response()->json(['code'=>401, 'data'=>[], 'msg'=>'请登录后操作']) : redirect()->route('admin.login');
            }
        } else {
            $isDefaultAdmin = getAdminAuth()->id() == 1 ? true : false;
            if (!$isDefaultAdmin && getAdminAuth()->user()->status == AdminUser::STATUS_INVALID) {
                getAdminAuth()->logout();
                return $request->ajax() ? response()->json(['code'=>401, 'data'=>[], 'msg'=>'您的账号已被禁用']) : redirect()->route('admin.login');
            }
            if (!$isDefaultAdmin || !in_array($currentRouteName, $noNeedRight)) {
                // 需要鉴权
            }
        }
        return $next($request);
    }
}
