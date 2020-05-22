<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

// 配置
class AdminConfig extends BaseModel
{
    // 软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    // 追加字段
    protected $appends = ['type_text'];

    // 类型
    const TYPE_INPUT = 1;
    const TYPE_TEXT_AREA = 2;
    const TYPE_RADIO = 3;
    const TYPE_CHECKBOX = 4;
    const TYPE_SELECT = 5;
    public $typeLabel = [self::TYPE_INPUT=>'单行文本', self::TYPE_TEXT_AREA=>'多行文本', self::TYPE_RADIO=>'单选按钮', self::TYPE_CHECKBOX=>'复选框', self::TYPE_SELECT=>'下拉框'];
    public function getTypeTextAttribute()
    {
        return $this->typeLabel[$this->type] ?? $this->type;
    }
}
