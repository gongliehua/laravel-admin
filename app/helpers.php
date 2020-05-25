<?php

// 后台权限信息
function getAdminAuth()
{
    return \Illuminate\Support\Facades\Auth::guard('admin');
}

// 检测权限(用于页面上按钮之类的)
function checkPermission($slug)
{
    if (getAdminAuth()->check()) {
        $isDefaultAdmin = getAdminAuth()->id() == 1 ? true : false;
        if (!$isDefaultAdmin && getAdminAuth()->user()->status == \App\Models\AdminUser::STATUS_INVALID) {
            return false;
        }
        if ($isDefaultAdmin && !config('admin.develop') && in_array($slug, config('admin.noNeedDevelop'))) {
            return false;
        }
        if (!$isDefaultAdmin && !in_array($slug, config('admin.noNeedRight'))) {
            // 需要鉴权
        }
    } else {
        if (!in_array($slug, config('admin.noNeedLogin'))) {
            return false;
        }
    }
    return true;
}

// 文件上传
function fileUpload(&$file, $exceptSuffix = ['php'])
{
    // 目录处理
    $relativePath = 'uploads/' . date('Y/m/d');
    $uploadPath = public_path($relativePath);
    if (!is_dir($uploadPath)) {
        @mkdir($uploadPath, 0777, true);
    }
    if (!is_writeable($uploadPath)) {
        return ['code'=>422, 'data'=>[], 'msg'=>'文件上传目录不可写'];
    }
    // 文件处理
    $fileSuffix = $file->getClientOriginalExtension();
    if (in_array($fileSuffix, $exceptSuffix)) {
        return ['code'=>422, 'data'=>[], 'msg'=>'该文件后缀禁止上传'];
    }
    $fileName = sha1(uniqid(null, true)) . '.' . $fileSuffix;
    $filePath = $relativePath . '/' . $fileName;
    return $file->move($uploadPath, $fileName) ? ['code'=>200, 'data'=>$filePath, 'msg'=>'文件上传成功'] : ['code'=>422, 'data'=>[], 'msg'=>'文件上传失败'];
}

// 无限级数组排序
function arraySort($data = [], $parent_id = 0, $level = 0, $clear = false)
{
    static $result = [];
    if ($clear) {
        $result = [];
        return $result;
    }
    foreach ($data as $key=>$value) {
        if ($value['parent_id'] == $parent_id) {
            $value['level'] = $level;
            $result[] = $value;
            arraySort($data, $value['id'], $level + 1);
        }
    }
    return $result;
}

// 无限级数组转换成多维数组
function toMultiArray($data = [], $parent_id = 0)
{
    $result = [];
    foreach ($data as $key=>$value) {
        if ($value['parent_id'] == $parent_id) {
            $value['child'] = toMultiArray($data, $value['id']);
            $result[] = $value;
        }
    }
    return $result;
}

// 无限级多维数组转换成菜单字符串
function toMenuHtml($data = [])
{
    $result = '';
    foreach ($data as $key=>$value) {
        if (empty($value['child'])) {
            $aTag  = '<a href="'. @route($value['slug']) .'"><i class="menu-icon fa '. $value['icon'] .'"></i><span class="menu-text">'. $value['name'] .'</span></a><b class="arrow"></b>';
        } else {
            $aTag  = '<a href="'. @route($value['slug']) .'" class="dropdown-toggle"><i class="menu-icon fa '. $value['icon'] .'"></i><span class="menu-text">'. $value['name'] .'</span><b class="arrow fa fa-angle-down"></b></a><b class="arrow"></b>';
        }
        $result .= '<li class="">'.$aTag;
        if (!empty($value['child'])) {
            $result .= '<ul class="submenu">'. toMenuHtml($value['child']) .'</ul>';
        }
        $result .= '</li>';
    }
    return $result;
}

// 无限级获取上级
function getParents($data = [], $id)
{
    $result = [];
    foreach ($data as $val) {
        if ($val['id'] == $id) {
            $result[] = $val;
            $result = array_merge(getParents($data, $val['parent_id']), $result);
        }
    }
    return $result;
}

// curl函数
function curlPost($url, $data = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if ($data) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// 所有权限
function allPermission()
{
    static $data = null;
    if ($data === null) {
        $data = \App\Models\AdminPermission::orderBy('sort', 'ASC')->get()->toArray();
        $data = arraySort($data);
        arraySort([], 0, 0, true);
    }
    return $data;
}

// 获取子权限ID
function getChildPermissionId($id)
{
    $allChildPermission = arraySort(allPermission(), $id);
    arraySort([], 0, 0, true);
    $allChildPermissionId = array_column($allChildPermission, 'id');
    return $allChildPermissionId;
}
