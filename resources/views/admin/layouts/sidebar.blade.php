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
                <li class="active">
                    <a href="{{ route('admin') }}">
                        <i class="fa fa-home"></i> <span>首页</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span>多级菜单</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-circle-o"></i> Level One
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                                <li class="treeview">
                                    <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
