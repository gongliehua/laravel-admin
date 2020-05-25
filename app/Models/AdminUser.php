<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

// 管理员
class AdminUser extends Authenticatable
{
    use Notifiable;

    // 软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 追加字段
    protected $appends = ['sex_text', 'status_text'];

    // 性别
    const SEX_UNKNOWN = 0;
    const SEX_MAN = 1;
    const SEX_WOMAN = 2;
    public $sexLabel = [self::SEX_UNKNOWN=>'保密', self::SEX_MAN=>'男', self::SEX_WOMAN=>'女'];
    public function getSexTextAttribute()
    {
        return $this->sexLabel[$this->sex] ?? $this->sex;
    }

    // 状态
    const STATUS_NORMAL = 1;
    const STATUS_INVALID = 2;
    public $statusLabel = [self::STATUS_NORMAL=>'正常', self::STATUS_INVALID=>'禁用'];
    public function getStatusTextAttribute()
    {
        return $this->statusLabel[$this->status] ?? $this->status;
    }

    // 获取关联的角色
    public function adminRole()
    {
        return $this->belongsToMany('admin_role_users', 'App\Models\AdminRole');
    }

    // 获取管理员直接拥有的权限
    public function adminPermission()
    {
        return $this->belongsToMany('admin_user_permissions', 'App\Models\AdminPermission');
    }

    // 个人信息
    public function profile($params)
    {
        $data = array_only($params, ['username', 'password', 'name', 'sex', 'avatar', 'status']);
        $model = AdminUser::where('id', getAdminAuth()->id())->update($data);
        return $model ? ['code'=>200, 'data'=>[], 'msg'=>'修改成功'] : ['code'=>400, 'data'=>[], 'msg'=>'修改失败'];
    }

    // 后台登录
    public function login($params)
    {
        // 查找管理员
        $model = AdminUser::where('username', $params['username'])->first();
        if (!$model) {
            return ['code'=>422, 'data'=>[], 'msg'=>'用户名或密码错误'];
        }
        // 验证密码
        if (!password_verify($params['password'], $model->password)) {
            return ['code'=>422, 'data'=>[], 'msg'=>'用户名或密码错误'];
        }
        // 验证状态(默认管理员不受限制)
        if ($model->id != 1 && $model->status == AdminUser::STATUS_INVALID) {
            return ['code'=>422, 'data'=>[], 'msg'=>'您的账号已被禁用'];
        }
        return ['code'=>200, 'data'=>$model, 'msg'=>'验证成功'];
    }
}
