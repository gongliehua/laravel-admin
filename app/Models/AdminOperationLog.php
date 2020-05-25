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

    // 列表
    public function search($params)
    {
        $query = new AdminOperationLog();
        $query = $query->with(['adminUser'=>function ($query) {
            $query->withTrashed();
        }]);
        if (isset($params['name']) && $params['name'] !== '') {
            $query = $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (isset($params['method']) && $params['method'] !== '') {
            $query = $query->where('method', 'like', '%' . $params['method'] . '%');
        }
        if (isset($params['path']) && $params['path'] !== '') {
            $query = $query->where('path', 'like', '%' . $params['path'] . '%');
        }
        if (isset($params['username']) && $params['username'] !== '') {
            $adminUserId = AdminUser::where('username', 'like', '%' . $params['username'] . '%')
                ->orWhere('name', 'like', '%' . $params['username'] . '%')
                ->pluck('id')->toArray();
            $query = $query->whereIn('admin_user_id', $adminUserId);
        }
        $query = $query->paginate();
        return $query;
    }
}
