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

    // 添加
    public function add($params)
    {
        $model = new AdminPermission();
        $model->parent_id = $params['parent_id'];
        $model->name = $params['name'];
        $model->slug = $params['slug'];
        $model->icon = $params['icon'];
        $model->is_menu = $params['is_menu'];
        $model->status = $params['status'];
        $model->sort = strlen($params['sort']) ? $params['sort'] : $this->max('sort') + 1;
        return $model->save() ? ['code'=>200, 'data'=>[], 'msg'=>'添加成功'] : ['code'=>400, 'data'=>[], 'msg'=>'添加失败'];
    }

    // 修改
    public function edit($params)
    {
        $data = array_only($params, ['parent_id', 'name', 'slug', 'icon', 'is_menu', 'status', 'sort']);
        $model = AdminPermission::where('id', $params['id'])->update($data);
        return $model ? ['code'=>200, 'data'=>[], 'msg'=>'修改成功'] : ['code'=>400, 'data'=>[], 'msg'=>'修改失败'];
    }

    // 删除
    public function del($id)
    {
        $info = AdminPermission::find($id);
        if (!$info) {
            return ['code'=>422, 'data'=>[], 'msg'=>'该信息未找到，建议刷新页面后重试！'];
        }
        // 拿到所有子权限ID
        $allChildPermissionId = getChildPermissionId($id);
        array_pull($allChildPermissionId, $id);

        // 删除
        AdminUserPermission::whereIn('admin_permission_id', $allChildPermissionId)->delete();
        AdminRolePermission::whereIn('admin_permission_id', $allChildPermissionId)->delete();
        AdminPermission::whereIn('id', $allChildPermissionId)->delete();

        return ['code'=>200, 'data'=>[], 'msg'=>'删除成功'];
    }

    // 排序
    public static function sort($params)
    {
        foreach ($params as $key=>$value) {
            AdminPermission::where('id', (int)$key)->update(['sort'=>(int)$value]);
        }
    }
}
