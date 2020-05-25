<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminPermission;
use App\Validate\PermissionValidate;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

// 权限
class PermissionController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        // 排序
        if ($request->isMethod('put')) {
            $sort = $request->input('sort');
            (new AdminPermission)->sort($sort);
            return ['code'=>200, 'data'=>[], 'msg'=>'排序成功'];
        }

        // 分页参数
        $page = (int) $request->input('page', 1);
        $pageSize = (int) $request->input('pageSize', 15);
        $offset = ($page - 1) * $pageSize;

        // 查找所有数据排序后再分页显示
        $result = allPermission();
        $result = new LengthAwarePaginator(array_slice($result, $offset, $pageSize), count($result), $pageSize, $page, ['path'=>$request->url(), 'query'=>$request->query()]);

        return view('admin.permission.index', compact('result'));
    }

    // 添加
    public function create(Request $request)
    {
        $params = $request->all();
        if ($request->isMethod('post')) {
            // 数据过滤
            $validate = PermissionValidate::add($params);
            if ($validate['code'] != 200) {
                return response()->json($validate);
            }
            // 数据操作
            $model = (new AdminPermission())->add($params);
            return response()->json($model);
        }
        $allPermission = allPermission();
        return view('admin.permission.create', compact('allPermission'));
    }

    // 修改
    public function update(Request $request)
    {
        $params = $request->all();
        if ($request->isMethod('put')) {
            // 数据过滤
            $validate = PermissionValidate::edit($params);
            if ($validate['code'] != 200) {
                return response()->json($validate);
            }
            // 数据操作
            $model = (new AdminPermission())->edit($params);
            return response()->json($model);
        }
        $info = AdminPermission::find($request->input('id'));
        if (!$info) {
            abort(422, '该信息未找到，建议刷新页面后重试！');
        }
        $allPermission = allPermission();
        return view('admin.permission.update', compact('info', 'allPermission'));
    }

    // 删除
    public function delete(Request $request)
    {
        $result = (new AdminPermission())->del($request->input('id'));
        return response()->json($result);
    }
}
