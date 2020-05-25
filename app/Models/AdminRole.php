<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        return $this->belongsToMany('App\Models\AdminPermission', 'admin_role_permissions');
    }

    // 列表
    public function search($params)
    {
        $query = new AdminRole();
        if (isset($params['name']) && $params['name'] !== '') {
            $query = $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (isset($params['status']) && $params['status'] !== '') {
            $query = $query->where('status', '=', $params['status']);
        }
        $query = $query->paginate();
        return $query;
    }

    // 添加
    public function add($params)
    {
        try {
            DB::beginTransaction();
            // 角色入库
            $model = new AdminRole();
            $model->name = $params['name'];
            $model->status = $params['status'];
            $model->remark = $params['remark'];
            if (!$model->save()) {
                throw new \Exception('添加失败');
            }
            // 权限入库
            if (isset($params['admin_permission_id']) && is_array($params['admin_permission_id'])) {
                $params['admin_permission_id'] = AdminPermission::whereIn('id', $params['admin_permission_id'])->pluck('id')->toArray();
                foreach ($params['admin_permission_id'] as $value) {
                    $adminRolePermission = new AdminRolePermission();
                    $adminRolePermission->admin_role_id = $model->id;
                    $adminRolePermission->admin_permission_id = $value;
                    if (!$adminRolePermission->save()) {
                        throw new \Exception('添加失败');
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ['code'=>400, 'data'=>[], 'msg'=>'添加失败'];
        }
        return ['code'=>200, 'data'=>[], 'msg'=>'添加成功'];
    }

    // 修改
    public function edit($params)
    {
        try {
            DB::beginTransaction();
            // 角色入库
            $model = AdminRole::find($params['id']);
            $model->name = $params['name'];
            $model->status = $params['status'];
            $model->remark = $params['remark'];
            if (!$model->save()) {
                throw new \Exception('修改失败');
            }
            // 权限入库
            AdminRolePermission::where('admin_role_id', $params['id'])->delete();
            if (isset($params['admin_permission_id']) && is_array($params['admin_permission_id'])) {
                $params['admin_permission_id'] = AdminPermission::whereIn('id', $params['admin_permission_id'])->pluck('id')->toArray();
                foreach ($params['admin_permission_id'] as $value) {
                    $adminRolePermission = new AdminRolePermission();
                    $adminRolePermission->admin_role_id = $model->id;
                    $adminRolePermission->admin_permission_id = $value;
                    if (!$adminRolePermission->save()) {
                        throw new \Exception('修改失败');
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ['code'=>400, 'data'=>[], 'msg'=>'修改失败'];
        }
        return ['code'=>200, 'data'=>[], 'msg'=>'修改成功'];
    }

    // 删除
    public function del($id)
    {
        AdminRole::destroy($id);
        AdminRoleUser::where('admin_role_id', $id)->delete();
        AdminRolePermission::where('admin_role_id', $id)->delete();
        return ['code'=>200, 'data'=>[], 'msg'=>'删除成功'];
    }
}
