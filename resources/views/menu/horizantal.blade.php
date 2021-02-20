<!-- Horizantal menu-->
<div class="ren-navbar fixed-header" id="headerMenuCollapse">
    <div class="container">
        <ul class="nav">
            @if($roleGlobal->permission('schedules.list'))
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('schedules*')||Request::is('schedules*') ? 'active' : '' }}"
                       href="{!! url('schedules') !!}"><i class="fas fa-calendar"></i><span>Lịch hẹn</span></a>
                </li>
            @endif

            @if($roleGlobal->permission('customers.list'))
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('customers*')||Request::is('customers*') ? 'active' : '' }}"
                       href="{!! route('customers.index') !!}"><i
                                class="fas fa-users"></i><span>Quản lý khách hàng</span></a>
                </li>
            @endif
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('fanpage*')||Request::is('posts*')||Request::is('customer-post*')||Request::is('rules*') ? 'active' : '' }}"
                   href="#"><i class="fas fa-magnet"></i><span>Marketing</span></a>
                <div class="sub-item">
                    <ul>
                        @if($roleGlobal->permission('fanpage'))
                            <li><a href="{{route('fanpage.index')}}">Fanpage </a></li>
                        @endif

                        @if(empty($permissions) || !in_array('rules.index',$permissions))
                            @if($roleGlobal->permission('rules.list'))
                                <li><a href="{{url('rules')}}">Automation </a></li>
                            @endif
                        @endif
                        @if(empty($permissions) || !in_array('landipages.index',$permissions))
                            @if($roleGlobal->permission('landipages.list'))
                                <li><a href="{{route('landipages.index')}}">Landing Page</a></li>
                            @endif
                        @endif
                        @if($roleGlobal->permission('posts.list'))
                            <li><a href="{{route('posts.index')}}">Optin Form</a></li>
                        @endif
                        @if(empty($permissions) || !in_array('promotions.index',$permissions))
                            @if($roleGlobal->permission('promotions.list'))
                                <li><a href="{{route('promotions.index')}}">Voucher khuyến mãi</a></li>
                            @endif
                        @endif
                        @if(empty($permissions) || !in_array('customer-post.index',$permissions))
                            @if($roleGlobal->permission('post.customer'))
                                <li><a href="{{route('post.customer')}}">Khách hàng từ form</a></li>
                            @endif
                        @endif
                    </ul>
                </div>
            </li>
            <li class="nav-item with-sub">
                <a class="nav-link {{ Request::is('category*')||Request::is('orders-payment')||Request::is('list-orders*')||Request::is('combos*')||Request::is('services*')||Request::is('products*')||Request::is('category-product*') ? 'active' : '' }}"
                   href="#"><i class="fas fa-newspaper"></i><span>Quản lý bán hàng</span></a>
                <div class="sub-item">
                    <ul>
                        @if($roleGlobal->permission('category.list'))
                            <li><a href="{!! route('category.index') !!}">Nhóm dịch vụ</a></li>
                        @endif
                        @if($roleGlobal->permission('category-product.list'))
                            <li><a href="{!! route('category-product.index') !!}">Nhóm sản phẩm</a></li>
                        @endif
                        @if($roleGlobal->permission('services.list'))
                            <li><a href="{!! route('services.index') !!}">Danh sách dịch vụ</a></li>
                        @endif
                        @if($roleGlobal->permission('products.list'))
                            <li><a href="{!! route('products.index') !!}">Danh sách sản phẩm</a></li>
                        @endif
                        @if($roleGlobal->permission('trademark.list'))
                            <li><a href="{!! route('trademark.index') !!}">Nhà cung cấp</a></li>
                        @endif
                        @if($roleGlobal->permission('genitives.list'))
                            <li><a href="{!! route('genitives.index') !!}">Nhóm tính cách</a></li>
                        @endif
                        @if($roleGlobal->permission('combos.list'))
                            <li><a href="{!! route('combos.index') !!}">Danh sách combo</a></li>
                        @endif
                        @if($roleGlobal->permission('order.list'))
                            <li><a href="{!! route('order.list') !!}">Danh sách đơn hàng</a></li>
                        @endif
                        @if($roleGlobal->permission('order.index_payment'))
                            <li><a href="{!! route('order.index_payment') !!}">Đã thu trong kỳ</a></li>
                        @endif

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('tasks') ? 'active' : '' }}" href="{{route('tasks.index')}}"><i
                            class="fas fa-tasks"></i><span>Công việc</span></a>
                @if($roleGlobal->permission('tasks.employee'))
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
                        @if($roleGlobal->permission('statistics.index'))
                            <li><a href="{{url('statistics')}}">Doanh thu</a></li>
                        @endif
                        @if($roleGlobal->permission('report.groupSale'))
                            <li><a href="{{url('report/group-sale/services')}}">Doanh thu nhóm DV</a></li>
                        @endif
                        @if($roleGlobal->permission('report.groupSale'))
                            <li><a href="{{url('report/group-sale/products')}}">Doanh thu nhóm SP</a></li>
                        @endif
                        @if($roleGlobal->permission('sms.history'))
                            <li><a href="{{url('history-sms')}}">Tin nhắn đã gửi</a></li>
                        @endif
                        @if($roleGlobal->permission('report.tasks'))
                            <li><a href="{{url('report/tasks')}}">Hiệu quả công việc</a></li>
                        @endif
                        @if($roleGlobal->permission('report.commission'))
                            <li><a href="{{url('report/commission')}}">Hoa hồng KTV</a></li>
                        @endif
                        @if($roleGlobal->permission('report.sale'))
                            <li><a href="{{url('report/sales')}}">Xếp hạng Telasales</a></li>
                        @endif
                        @if($roleGlobal->permission('statistics.taskSchedules'))
                            <li><a href="{{url('statistics-task')}}">BĐ C.việc & lịch hẹn</a></li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- Horizantal menu-->
