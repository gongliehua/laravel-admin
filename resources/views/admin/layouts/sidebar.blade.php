    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ ($avatar = getAdminAuth()->user()->avatar) ? asset($avatar) : config('admin.avatar') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ getAdminAuth()->user()->name }}</p>
                    <a href="javascript:;"><i class="fa fa-circle text-success"></i> 在线</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">菜单</li>
                {{-- 首页每个人都有权限看，所以直接写在这里 --}}
                <li @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin') class="active" @endif >
                    <a href="{{ route('admin') }}">
                        <i class="fa fa-home"></i> <span>首页</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="javascript:;">
                        <i class="fa fa-group"></i> <span>用户管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.admin_user') }}"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                        <li><a href="{{ route('admin.role') }}"><i class="fa fa-circle-o"></i> 角色管理</a></li>
                        <li><a href="{{ route('admin.permission') }}"><i class="fa fa-circle-o"></i> 权限管理</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="javascript:;">
                        <i class="fa fa-gears"></i> <span>系统管理</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.setting') }}"><i class="fa fa-circle-o"></i> 系统设置</a></li>
                        <li><a href="{{ route('admin.operation_log') }}"><i class="fa fa-circle-o"></i> 日志列表</a></li>
                    </ul>
                </li>
                {{-- 开发时辅助功能，所以直接写在这里 --}}
                @if(config('admin.develop') && getAdminAuth()->id() == 1)
                    <li @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'admin.config') class="active" @endif >
                        <a href="{{ route('admin.config') }}">
                            <i class="fa fa-circle-o"></i> <span>配置管理</span>
                        </a>
                    </li>
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
