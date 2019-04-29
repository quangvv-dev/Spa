<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a href="{!! route('users.index') !!}" class="nav-link {{ Request::is('admin/menu*') ? 'active' : '' }}">
                    <i class="fa fa-users"></i>
                    <span>Quản Lý Người Dùng</span>
                </a>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Cài đặt chung</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! route('status.index') !!}">Nhóm / trạng thái</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Quản lý dịch vụ</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! route('category.index') !!}">Danh mục dịch vụ</a>
                        </li>
                        <li>
                            <a href="{!! route('services.index') !!}">Quản lý dịch vụ</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
