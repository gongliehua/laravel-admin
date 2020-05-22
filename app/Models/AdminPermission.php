<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

// 权限
class AdminPermission extends BaseModel
{
    // 软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 追加字段
    protected $appends = ['is_menu_text', 'status_text'];

    // 菜单
    const IS_MENU_ON = 1;
    const IS_MENU_OFF = 2;
    public $is_menuLabel = [self::IS_MENU_ON=>'是', self::IS_MENU_OFF=>'否'];
    public function getIsMenuTextAttribute()
    {
        return $this->is_menuLabel[$this->is_menu] ?? $this->is_menu;
    }

    // 状态
    const STATUS_NORMAL = 1;
    const STATUS_INVALID = 2;
    public $statusLabel = [self::STATUS_NORMAL=>'正常', self::STATUS_INVALID=>'禁用'];
    public function getStatusTextAttribute()
    {
        return $this->statusLabel[$this->status] ?? $this->status;
    }

    // 获取父级权限信息
    public function adminPermission()
    {
        return $this->belongsTo('App\Models\AdminPermission', 'parent_id', 'id');
    }
}
