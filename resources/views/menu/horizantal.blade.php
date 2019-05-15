<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            @if(Auth::user()->role == App\Constants\UserConstant::ADMIN)
                <li class="nav-item with-sub" {{ Request::is('category*')||Request::is('services*') ? 'active' : '' }}>
                    <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Quản lý khách hàng</span></a>
                    <div class="sub-item">
                        <ul>
                            <li>
                                <a href="#">Nhóm khách hàng </a>
                            </li>
                            <li>
                                <a href="{!! route('customers.index') !!}">Danh sách khách hàng</a>
                            </li>
                            <li>
                                <a href="#">Nhân viên phụ trách </a>
                            </li>
                            <li>
                                <a href="#">Quản lý trạng thái</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item with-sub" {{ Request::is('category*')||Request::is('services*') ? 'active' : '' }}>
                    <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Marketing</span></a>
                    <div class="sub-item">
                        <ul>
                            <li>
                                <a href="#">Fanpage </a>
                            </li>
                            <li>
                                <a href="#">SMS</a>
                            </li>
                            <li>
                                <a href="#">Automation </a>
                            </li>
                            <li>
                                <a href="#">Chiến dịch</a>
                            </li>
                            <li>
                                <a href="#">From </a>
                            </li>
                            <li>
                                <a href="#">Landing Page</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item with-sub" {{ Request::is('category*')||Request::is('services*') ? 'active' : '' }}>
                    <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Quản lý bán hàng</span></a>
                    <div class="sub-item">
                        <ul>
                            <li>
                                <a href="{!! route('category.index') !!}">Danh mục dịch vụ</a>
                            </li>
                            <li>
                                <a href="{!! route('services.index') !!}">Danh sách dịch vụ</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{--<li class="nav-item">--}}
                    {{--<a href="{!! route('status.index') !!}" class="nav-link {{ Request::is('status*') ? 'active' : '' }}">--}}
                        {{--<i class="fa fa-users"></i>--}}
                        {{--<span>Quản Lý Trạng Thái</span>--}}
                    {{--</a>--}}
                {{--</li>--}}
            @endif
            <li class="nav-item with-sub" {{ Request::is('statistics*') ? 'active' : '' }}>
                <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Thống kê</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="#">Khách hàng</a>
                        </li>
                        <li>
                            <a href="{!! url('statistics')!!}">Nhân viên</a>
                        </li>
                        <li class="sub-with-sub">
                            <a href="#">KPI </a>
                            <ul>
                                <li>
                                    <a href="#">KPI chi nhánh</a>
                                </li>
                                <li>
                                    <a href="#html">KPI nhân viên</a>
                                </li>
                            </ul>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{!! url('statistics')!!}">Marketing</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
