<?php

namespace App\Validate;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// 管理员
class AdminUserValidate
{
    // 后台登录
    public static function login($params)
    {
        $rules = [
            'username'=>'required|alpha_num|between:3,20',
            'password'=>'required|alpha_dash|between:6,20',
        ];
        $messages = [];
        $customAttributes = [
            'username'=>'用户名',
            'password'=>'密码',
        ];
        $validator = Validator::make($params, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return ['code'=>422, 'data'=>[], 'msg'=>$validator->errors()->first()];
        }
        return ['code'=>200, 'data'=>[], 'msg'=>'验证成功'];
    }

    // 个人信息
    public static function profile($params)
    {
        $admin = getAdminAuth()->user();
        $rules = [
            'username'=>['required', 'alpha_num', 'between:3,20', Rule::unique('admin_users')->where(function ($query) use ($admin) {
                $query->whereNull('deleted_at')->where('id', '!=', $admin->id);
            })],
            'password'=>'present|nullable|alpha_dash|between:6,20|confirmed',
            'name'=>'required|string|between:3,20',
            'sex'=>'required|in:' . implode(',', array_keys($admin->sexLabel)),
            'avatar'=>'image',
            'email'=>'present|nullable|email|max:200',
            'status'=>'required|in:' . implode(',', array_keys($admin->statusLabel)),
        ];
        $messages = [];
        $customAttributes = [
            'username'=>'用户名',
            'password'=>'密码',
            'name'=>'姓名',
            'sex'=>'性别',
            'avatar'=>'头像',
            'email'=>'电子邮箱',
            'status'=>'状态',
        ];
        $validator = Validator::make($params, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return ['code'=>422, 'data'=>[], 'msg'=>$validator->errors()->first()];
        }
        return ['code'=>200, 'data'=>[], 'msg'=>'验证成功'];
    }
}
