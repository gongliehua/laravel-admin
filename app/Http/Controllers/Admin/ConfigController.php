<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminConfig;
use Illuminate\Http\Request;

// 配置
class ConfigController extends BaseController
{
    // 列表
    public function index(Request $request)
    {
        $result = AdminConfig::paginate();
        return view('admin.config.index', compact('result'));
    }
}
