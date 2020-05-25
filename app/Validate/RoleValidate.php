<?php

namespace App\Validate;

use App\Models\AdminPermission;
use App\Models\AdminRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// 角色
class RoleValidate
{
    // 添加
    public static function add($params)
    {
        $model = (new AdminRole());
        $rules = [
            'name'=>'required|string|max:20',
            'status'=>'required|in:' . implode(',', array_keys($model->statusLabel)),
            'remark'=>'present|nullable|string|max:200',
            'admin_permission_id'=>'nullable|array',
        ];
        $messages = [];
        $customAttributes = [
            'name'=>'名称',
            'status'=>'状态',
            'remark'=>'备注',
            'admin_permission_id'=>'权限ID',
        ];
        $validator = Validator::make($params, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return ['code'=>422, 'data'=>[], 'msg'=>$validator->errors()->first()];
        }
        return ['code'=>200, 'data'=>[], 'msg'=>'验证成功'];
    }

    // 修改
    public static function edit($params)
    {
        $model = (new AdminRole());
        $rules = [
            'id'=>['required', Rule::exists('admin_roles')->where(function($query){
                $query->whereNull('deleted_at');
            })],
            'name'=>'required|string|max:20',
            'status'=>'required|in:' . implode(',', array_keys($model->statusLabel)),
            'remark'=>'present|nullable|string|max:200',
            'admin_permission_id'=>'nullable|array',
        ];
        $messages = [];
        $customAttributes = [
            'id'=>'角色ID',
            'name'=>'名称',
            'status'=>'状态',
            'remark'=>'备注',
            'admin_permission_id'=>'权限ID',
        ];
        $validator = Validator::make($params, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return ['code'=>422, 'data'=>[], 'msg'=>$validator->errors()->first()];
        }
        return ['code'=>200, 'data'=>[], 'msg'=>'验证成功'];
    }

    // 删除
    public static function del($params)
    {
        $rules = [
            'id'=>['required', Rule::exists('admin_roles')->where(function($query){
                $query->whereNull('deleted_at');
            })],
        ];
        $messages = [];
        $customAttributes = [
            'id'=>'角色ID',
        ];
        $validator = Validator::make($params, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return ['code'=>422, 'data'=>[], 'msg'=>$validator->errors()->first()];
        }
        return ['code'=>200, 'data'=>[], 'msg'=>'验证成功'];
    }
}
