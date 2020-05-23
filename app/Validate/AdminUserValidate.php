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
            'username'=>'required|string|between:3,20',
            'password'=>'required|string|between:6,20',
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
}
