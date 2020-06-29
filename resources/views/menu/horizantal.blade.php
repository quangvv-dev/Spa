<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item" {{ Request::is('schedules*')||Request::is('schedules*') ? 'active' : '' }}>
                <a class="nav-link" href="{!! url('schedules') !!}"><i
                        class="fas fa-newspaper"></i><span>Lịch hẹn</span></a>
            </li>
            <li class="nav-item" {{ Request::is('customers*')||Request::is('customers*') ? 'active' : '' }}>
                <a class="nav-link" href="{!! route('customers.index') !!}"><i class="fas fa-newspaper"></i><span>Quản lý khách hàng</span></a>
            </li>
            {{--<li class="nav-item with-sub" {{ Request::is('customers*') ? 'active' : '' }}>--}}
            {{--<a class="nav-link" href="{!! route('customers.index') !!}"><i class="fas fa-newspaper"></i><span>Quản lý khách hàng</span></a>--}}
            {{--<div class="sub-item">--}}
            {{--<ul>--}}
            {{--<li>--}}
            {{--<a href="{!! route('customers.index') !!}">Khách hàng </a>--}}
            {{--</li>--}}
            {{--                        <li>--}}
            {{--                            <a href="{{url('schedules')}}">Lịch hẹn </a>--}}
            {{--                        </li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</li>--}}
            <li class="nav-item with-sub" {{ Request::is('category*')||Request::is('services*') ? 'active' : '' }}>
                <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Marketing</span></a>
                <div class="sub-item">
                    <ul>
                        <li>
                            <a href="{{route('fanpage.index')}}">Fanpage </a>
                        </li>
                        <li>
                            <a href="#">SMS</a>
                        </li>
                        @if(Auth::user()->role ==  App\Constants\UserConstant::ADMIN)
                            <li>
                                <a href="{{url('rules')}}">Automation </a>
                            </li>
                        @endif
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
                            <a href="{!! route('category.index') !!}">Nhóm dịch vụ</a>
                        </li>
                        <li>
                            <a href="{!! route('services.index') !!}">Danh sách dịch vụ</a>
                        </li>
                        <li>
                            <a href="{!! route('products.index') !!}">Danh sách sản phẩm</a>
                        </li>
                        <li>
                            <a href="{!! route('combos.index') !!}">Danh sách combo</a>
                        </li>
                        <li>
                            <a href="{!! route('order.list') !!}">Danh sách đơn hàng</a>
                        </li>
                        <li>
                            <a href="{!! route('order.index_payment') !!}">Đã thu trong kỳ</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item with-sub" {{ Request::is('statistics*') ? 'active' : '' }}>
                <a class="nav-link" href="#"><i class="fas fa-newspaper"></i><span>Thống kê</span></a>
                <div class="sub-item">
                    <ul>
                        {{--                        <li>--}}
                        {{--                            <a href="#">Doanh thu</a>--}}
                        {{--                        </li>--}}
                        <li>
                            <a href="{{url('report/customers')}}">Doanh thu</a>
                        </li>
                        <li>
                            {{--                            <a href="{!! url('statistics')!!}">Nhân viên</a>--}}
                        </li>
                        <li>
                            <a href="#">Chiến dịch</a>
                        </li>
                        {{--                        <li>--}}
                        {{--                            <a href="{{url('report/products')}}">Sản phẩm</a>--}}
                        {{--                        </li>--}}
                        <li>
                            <a href="{{route('tasks.index')}}">Công việc</a>
                        </li>
                        <li>
                            <a href="{{url('report/sales')}}">Xếp hạng Telasales</a>
                        </li>
                        <li>
                            <a href="{{url('report/group-sale')}}">Doanh thu nhóm DV</a>
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
