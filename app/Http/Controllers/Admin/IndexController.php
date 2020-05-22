<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use App\Validate\AdminUserValidate;
use Illuminate\Http\Request;

// 基本操作
class IndexController extends BaseController
{
    // 后台登录
    public function login(Request $request)
    {
        $params = $request->all();
        if ($request->isMethod('post')) {
            $validate = AdminUserValidate::login($params);
            if ($validate['code'] != 200) {
                return response()->json($validate);
            }
            $adminUser = (new AdminUser())->login($params);
            if ($adminUser['code'] != 200) {
                return response()->json($adminUser);
            }
            $remember = $request->has('remember');
            getAdminAuth()->login($adminUser['data'], $remember);
            return response()->json(['code'=>200, 'msg'=>'登录成功', 'data'=>[]]);
        }
        return view('admin.login');
    }

    // 退出登录
    public function logout(Request $request)
    {
        getAdminAuth()->logout();
        return redirect()->route('admin.login');
    }
}
