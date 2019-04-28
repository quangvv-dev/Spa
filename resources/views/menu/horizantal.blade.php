<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a href="{!! route('users.index') !!}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                    <i class="fa fa-users"></i>
                    <span>Quản Lý Người Dùng</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{!! route('status.index') !!}" class="nav-link {{ Request::is('status*') ? 'active' : '' }}">
                    <i class="fa fa-users"></i>
                    <span>Quản Lý Trạng Thái</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
