<?php

// 后台权限信息
function getAdminAuth()
{
    return \Illuminate\Support\Facades\Auth::guard('admin');
}
