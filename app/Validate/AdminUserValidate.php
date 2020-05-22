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
        $rules = [];
        $messages = [];
        $customAttributes = [];
        $validator = Validator::make($params, $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            return ['code'=>422, 'msg'=>$validator->errors()->first(), 'data'=>[]];
        }
        return ['code'=>200, 'msg'=>'验证成功', 'data'=>[]];
    }
}
