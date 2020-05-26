<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminRole;
use App\Models\AdminRolePermission;
use App\Models\AdminRoleUser;
use App\Models\AdminUser;
use App\Models\AdminUserPermission;
use App\Validate\AdminUserValidate;
use App\Validate\RoleValidate;
use Illuminate\Http\Request;

// 管理员
class AdminUserController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $params = $request->all();
        $result = (new AdminUser())->search($params);
        return view('admin.adminUser.index', compact('result'));
    }

    // 添加
    public function create(Request $request)
    {
        $params = $request->all();
        if ($request->isMethod('post')) {
            // 数据过滤
            $validate = AdminUserValidate::add($params);
            if ($validate['code'] != 200) {
                return response()->json($validate);
            }
            // 密码处理
            if ($request->filled('password')) {
                $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
            } else {
                $params['password'] = password_hash('123456', PASSWORD_DEFAULT);
            }
            // 头像处理
            if ($avatar = $request->file('avatar')) {
                $avatarResult = fileUpload($avatar);
                if ($avatarResult['code'] == 200) {
                    $params['avatar'] = $avatarResult['data'];
                } else {
                    return response()->json($avatarResult);
                }
            } else {
                $params['avatar'] = null;
            }
            // 数据操作
            $model = (new AdminUser())->add($params);
            return response()->json($model);
        }
        $allRole = AdminRole::all();
        $allPermission = allPermission();
        return view('admin.adminUser.create', compact('allRole', 'allPermission'));
    }

    // 查看
    public function show(Request $request)
    {
        $info = AdminUser::find($request->input('id'));
        if (!$info) {
            abort(422, '该信息未找到，建议刷新页面后重试！');
        }
        $adminRoleId = AdminRoleUser::where('admin_user_id', $info->id)->pluck('admin_role_id')->toArray();
        $adminPermissionId = AdminUserPermission::where('admin_user_id', $info->id)->pluck('admin_permission_id')->toArray();
        $allRole = AdminRole::all();
        $allPermission = allPermission();
        return view('admin.adminUser.show', compact('info', 'adminRoleId', 'adminPermissionId', 'allRole', 'allPermission'));
    }

    // 修改
    public function update(Request $request)
    {
        $params = $request->all();
        if ($request->isMethod('put')) {
            // 数据过滤
            $validate = AdminUserValidate::edit($params);
            if ($validate['code'] != 200) {
                return response()->json($validate);
            }
            // 密码处理
            if ($request->filled('password')) {
                $params['password'] = password_hash($params['password'], PASSWORD_DEFAULT);
            } else {
                // 不修改密码
                unset($params['password']);
            }
            // 头像处理
            if ($avatar = $request->file('avatar')) {
                $avatarResult = fileUpload($avatar);
                if ($avatarResult['code'] == 200) {
                    $params['avatar'] = $avatarResult['data'];
                } else {
                    return response()->json($avatarResult);
                }
            } else {
                // 不修改头像
                unset($params['avatar']);
            }
            // 默认管理员不受状态限制
            if ($params['id'] == 1) {
                $params['status'] = AdminUser::STATUS_NORMAL;
            }
            // 数据操作
            $model = (new AdminUser())->edit($params);
            return response()->json($model);
        }
        $info = AdminUser::find($request->input('id'));
        if (!$info) {
            abort(422, '该信息未找到，建议刷新页面后重试！');
        }
        $adminRoleId = AdminRoleUser::where('admin_user_id', $info->id)->pluck('admin_role_id')->toArray();
        $adminPermissionId = AdminUserPermission::where('admin_user_id', $info->id)->pluck('admin_permission_id')->toArray();
        $allRole = AdminRole::all();
        $allPermission = allPermission();
        return view('admin.adminUser.update', compact('info', 'adminRoleId', 'adminPermissionId', 'allRole', 'allPermission'));
    }

    // 删除
    public function delete(Request $request)
    {
        $params = $request->all();
        // 数据过滤
        $validate = AdminUserValidate::del($params);
        if ($validate['code'] != 200) {
            return response()->json($validate);
        }
        // 数据操作
        $model = (new AdminUser())->del($params['id']);
        return response()->json($model);
    }
}
