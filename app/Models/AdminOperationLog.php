<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

// 操作日志
class AdminOperationLog extends BaseModel
{
    // 软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 获取管理员信息(操作人)
    public function adminUser()
    {
        return $this->belongsTo('App\Models\AdminUser');
    }
}
