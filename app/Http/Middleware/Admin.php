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
        // 登录状态(默认管理员是不受状态、权限限制的) || 未登陆状态
        if (getAdminAuth()->check()) {
            $isDefaultAdmin = getAdminAuth()->id() == 1 ? true : false;
            if (!$isDefaultAdmin && getAdminAuth()->user()->status == AdminUser::STATUS_INVALID) {
                getAdminAuth()->logout();
                return $request->ajax() ? response()->json(['code'=>401, 'data'=>[], 'msg'=>'您的账号已被禁用']) : redirect()->route('admin.login');
            }
            if ($isDefaultAdmin && !config('admin.develop') && in_array($currentRouteName, config('admin.noNeedDevelop'))) {
                $msg = '该功能已关闭。如需使用，请开启开发模式';
                return $request->ajax() ? response()->json(['code'=>422, 'data'=>[], 'msg'=>$msg]) : abort(422, $msg);
            }
            if (!$isDefaultAdmin && !in_array($currentRouteName, config('admin.noNeedRight'))) {
                // 需要鉴权
            }
        } else {
            if (!in_array($currentRouteName, config('admin.noNeedLogin'))) {
                return $request->ajax() ? response()->json(['code'=>401, 'data'=>[], 'msg'=>'请登录后操作']) : redirect()->route('admin.login');
            }
        }
        return $next($request);
    }
}
