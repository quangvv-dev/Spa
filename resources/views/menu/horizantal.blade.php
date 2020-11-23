<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('schedules*')||Request::is('schedules*') ? 'active' : '' }}"
                   href="{!! url('schedules') !!}"><i
                        class="fas fa-calendar"></i><span>Lịch hẹn</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('customers*')||Request::is('customers*') ? 'active' : '' }}"
                   href="{!! route('customers.index') !!}"><i
                        class="fas fa-users"></i><span>Quản lý khách hàng</span></a>
            </li>

            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('fanpage*')||Request::is('posts*')||Request::is('customer-post*')||Request::is('rules*') ? 'active' : '' }}"
                   href="#"><i class="fas fa-magnet"></i><span>Marketing</span></a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{{route('fanpage.index')}}">Fanpage </a></li>
                        @if(Auth::user()->role ==  App\Constants\UserConstant::ADMIN|| (Auth::user()->role==App\Constants\UserConstant::TELESALES && Auth::user()->is_leader==\App\Constants\UserConstant::IS_LEADER ) )
                            @if(empty($permissions) || !in_array('rules.index',$permissions))
                                <li>
                                    <a href="{{url('rules')}}">Automation </a>
                                </li>
                            @endif
                            @if(empty($permissions) || !in_array('landipages.index',$permissions))
                                <li>
                                    <a href="{{route('landipages.index')}}">Landing Page</a>
                                </li>
                            @endif
                                <li>
                                    <a href="{{route('posts.index')}}">Optin Form</a>
                                </li>
                            @if(empty($permissions) || !in_array('promotions.index',$permissions))
                                <li>
                                    <a href="{{route('promotions.index')}}">Voucher khuyến mãi</a>
                                </li>
                            @endif
                        @endif
                        @if(empty($permissions) || !in_array('customer-post.index',$permissions))
                            <li><a href="{{route('post.customer')}}">Khách hàng từ form</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('category*')||Request::is('orders-payment')||Request::is('list-orders*')||Request::is('combos*')||Request::is('services*')||Request::is('products*')||Request::is('category-product*') ? 'active' : '' }}"
                   href="#"><i class="fas fa-newspaper"></i><span>Quản lý bán hàng</span></a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{!! route('category.index') !!}">Nhóm dịch vụ</a></li>
                        <li><a href="{!! route('category-product.index') !!}">Nhóm sản phẩm</a></li>
                        <li><a href="{!! route('services.index') !!}">Danh sách dịch vụ</a></li>
                        <li><a href="{!! route('products.index') !!}">Danh sách sản phẩm</a></li>
                        <li><a href="{!! route('combos.index') !!}">Danh sách combo</a></li>
                        <li><a href="{!! route('order.list') !!}">Danh sách đơn hàng</a></li>
                        <li><a href="{!! route('order.index_payment') !!}">Đã thu trong kỳ</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('tasks') ? 'active' : '' }}" href="{{route('tasks.index')}}"><i
                        class="fas fa-tasks"></i><span>Công việc</span></a>
                @if(Auth::user()->role ==  App\Constants\UserConstant::ADMIN)
                    <div class="sub-item">
                        <ul>
                            <li><a href="{!! url('tasks-employee') !!}">Công việc theo sale</a></li>
                        </ul>
                    </div>
                @endif
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('statistics*')||Request::is('report*')||Request::is('history-sms') ? 'active' : '' }}"
                   href="#"><i class="fas fa-search"></i><span>Thống kê</span></a>
                <div class="sub-item">
                    <ul>
                        @if(Auth::user()->role ==  App\Constants\UserConstant::ADMIN)
                            <li><a href="{{url('statistics')}}">Doanh thu</a></li>
                            <li><a href="{{url('report/group-sale/services')}}">Doanh thu nhóm DV</a></li>
                            <li><a href="{{url('report/group-sale/products')}}">Doanh thu nhóm SP</a></li>
                            <li><a href="{{url('history-sms')}}">Tin nhắn đã gửi</a></li>
                        @endif
                        <li><a href="{{url('report/group-sale/tasks')}}">Hiệu quả công việc</a></li>
                        <li><a href="{{url('report/commission')}}">Hoa hồng nhân viên</a></li>
                        <li><a href="{{url('report/sales')}}">Xếp hạng Telasales</a></li>
                        <li><a href="{{url('statistics-task')}}">BĐ C.việc & lịch hẹn</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
