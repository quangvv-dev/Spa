<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            {{--            <li class="nav-item" {{ Request::is('category*')||Request::is('services*') ? 'active' : '' }}>--}}
            {{--                <a class="nav-link" href="{!! route('customers.index') !!}"><i class="fas fa-newspaper"></i><span>Quản lý khách hàng</span></a>--}}
            {{--            </li>--}}
            <li class="nav-item with-sub" {{ Request::is('customers*') ? 'active' : '' }}>
                <a class="nav-link" href="{!! route('customers.index') !!}"><i class="fas fa-newspaper"></i><span>Quản lý khách hàng</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{!! route('customers.index') !!}">Khách hàng </a>
                        </li>
                        <li>
                            <a href="{{url('schedules')}}">Lịch hẹn </a>
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
                            <a href="#">Optin Form</a>
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
                        <li>
                            <a href="{!! route('order.list') !!}">Danh sách đơn hàng</a>
                        </li>
                        <li>
                            <a href="{!! route('order.list') !!}">Kho</a>
                        </li>
                    </ul>
                </div>
            </li>
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
                        <li>
                            <a href="#">Chiến dịch</a>
                        </li>
                        <li>
                            <a href="#">Sản phẩm</a>
                        </li>
                        <li>
                            <a href="#">Công việc</a>
                        </li>
                        <li>
                            <a href="#">Báo cáo Telesale</a>
                        </li>
                        <li>
                            <a href="#">Người bán hàng Xuất sắc</a>
                        </li>
                        <li>
                            <a href="#">Quà tặng</a>
                        </li>
                        {{--<li class="sub-with-sub">--}}
                        {{--<a href="#">KPI </a>--}}
                        {{--<ul>--}}
                        {{--<li>--}}
                        {{--<a href="#">KPI chi nhánh</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#html">KPI nhân viên</a>--}}
                        {{--</li>--}}
                        {{--</ul>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
