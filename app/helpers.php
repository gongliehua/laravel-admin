<?php

// 后台权限信息
function getAdminAuth()
{
    return \Illuminate\Support\Facades\Auth::guard('admin');
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
    return $file->move($uploadPath, $fileName) ? ['code'=>200, 'data'=>[], 'msg'=>$filePath] : ['code'=>422, 'data'=>[], 'msg'=>'文件上传失败'];
}
