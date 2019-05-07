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
            @if(Auth::user()->role == App\Constants\UserConstant::ADMIN)
                <li class="nav-item with-sub" {{ Request::is('category*')||Request::is('services*') ? 'active' : '' }}>
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
                <li class="nav-item">
                    <a href="{!! route('status.index') !!}" class="nav-link {{ Request::is('status*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i>
                        <span>Quản Lý Trạng Thái</span>
                    </a>
                </li>
            @endif
            <li class="nav-item with-sub" {{ Request::is('statistics*') ? 'active' : '' }}>
                <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Thống kê</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! url('statistics')!!}">Marketing</a>
                        </li>
{{--                        <li>--}}
{{--                            <a href="{!! route('services.index') !!}">Quản lý dịch vụ</a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
