<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

// 角色
class AdminRole extends BaseModel
{
    // 软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 追加字段
    protected $appends = ['status_text'];

    // 状态
    const STATUS_NORMAL = 1;
    const STATUS_INVALID = 2;
    public $statusLabel = [self::STATUS_NORMAL=>'正常', self::STATUS_INVALID=>'禁用'];
    public function getStatusTextAttribute()
    {
        return $this->statusLabel[$this->status] ?? $this->status;
    }

    // 获取权限
    public function adminPermission()
    {
        return $this->belongsToMany('admin_role_permissions', 'App\Models\AdminPermission');
    }
}
