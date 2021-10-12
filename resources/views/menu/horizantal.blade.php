@php
    $roleGlobal = auth()->user()?:[];
    $checkRole = checkRoleAlready();
@endphp
<style>
    .nav-link.icon.notification {
        border: solid 1px #7abaff;
    }

    .dropdown-custom .username {
        line-height: 3.5;
    }

    .position0 {
        position: absolute !important;
        top: 0;
        right: 0;
    }

    .margin-right0 i {
        margin-right: 0 !important;
    }

    .avatar {
        display: table-cell;
        vertical-align: top;
        width: 52px;
        height: 52px;
        -webkit-box-sizing: none;
        box-sizing: none;
    }

    @media only screen and (max-width: 1367px) {
        .ren-navbar .nav-link {
            padding: 1.3rem 0.9rem;
        }
    }

    .div-info {
        position: absolute !important;
        top: 4px;
        right: 0;
    }

    .left {
        float: left;
    }
</style>
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
                <a class="nav-link {{ Request::is('tasks') ? 'active' : '' }}"
                   href="{{route('tasks.index')}}">
                    <i class="fas fa-tasks"></i><span>CSKH</span></a>
                <div class="sub-item">
                    <ul>
                        @if($roleGlobal->permission('tasks.employee'))
                            <li><a href="{{url('tasks')}}">CSKH nhân viên</a></li>
                            <li><a href="{{url('tasks-employee')}}">CSKH phòng ban</a></li>
                        @endif
                    </ul>
                </div>
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
                        @if($roleGlobal->permission('call-center'))
                            <li><a href="{{route('call-center.index')}}">Quản lý tổng đài</a></li>
                        @endif
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('depots/product') ? 'active' : '' }}" href="#">
                    <i class="fas fa-tasks"></i><span>KHO VẬN</span></a>
                <div class="sub-item">
                    <ul>
                        <li><a href="{{url('depots/product')}}">Sản phẩm kho</a></li>
                        <li><a href="{{url('depots/history')}}">Lich sử nhập, xuất kho</a></li>
                        <li><a href="{{url('depots/statistical')}}">Báo cáo tồn</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="div-info">
            <div class="left">
                <input id="check_notify" type="hidden">
                <div class="dropdown dropdown-notification d-none d-md-flex">
                    <a class="nav-link icon notification margin-right0" data-toggle="dropdown"><i
                            style="color: #3691ef;"
                            class="fas fa-bell"></i> <span
                            class="badge badge-danger badge-pill position0">10</span></a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow"
                         style="overflow: auto;max-height: 400px">
                        <a class="dropdown-item text-center text-dark" href="#">2 New Messages</a>
                        <div class="dropdown-divider"></div>
                        <div class="content-notify">

                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center text-muted-dark"
                           href="{{route('notifications.index')}}">Xem tất cả</a>
                    </div>
                </div>

                <audio id="myAudio">
                    <source src="{{asset('default/sound-notification.mp3')}}" type="audio/ogg">
                </audio>
                <button id="btn_audio" style="display: none"></button>
            </div>
            <div class="right">
                <div class="dropdown dropdown-custom">
                    <a class="pr-0 leading-none d-flex" data-toggle="dropdown" href="#">
                        @if(\Auth::user()->avatar)
                            <span class="avatar avatar-md brround "
                                  style="background-image: url({{ url(\Auth::user()->avatar) }})"></span>
                        @else
                            <span class="avatar avatar-md brround"
                                  style="background-image: url(/assets/images/faces/female/25.jpg)"></span>
                        @endif
                        <span class="ml-2 d-none d-lg-block username">
                    <span class="" style="color: #7490BD">{!! Auth::user()->full_name !!}</span>
                </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" href="{{ url('users/'.Auth::user()->id . '/edit') }}"><i
                                class="dropdown-icon mdi mdi-face-profile"></i> Cài đặt tài khoản</a>
                        @if($roleGlobal->permission('users.list'))
                            <a class="dropdown-item" href="{!! route('users.index') !!}"><i
                                    class="dropdown-icon mdi mdi-account-outline"></i> Quản lý người dùng</a>
                        @endif

                        @if($roleGlobal->permission('department.list'))
                            <a class="dropdown-item" href="{!! route('department.index') !!}"><i
                                    class="dropdown-icon mdi mdi-account-multiple"></i> Quản lý phòng ban</a>
                        @endif

                        @if(empty($permissions) || !in_array('sms.index',$permissions))
                            @if($roleGlobal->permission('sms'))
                                <a class="dropdown-item" href="{!! route('sms.index') !!}">
                                    <i class="dropdown-icon fas fa-envelope"></i> Quản lý tin nhắn
                                </a>
                            @endif
                        @endif
                        @if($roleGlobal->permission('status.list'))
                            <a class="dropdown-item" href="{!! route('status.index') !!}"><i
                                    class="dropdown-icon mdi mdi-account-card-details"></i> Quản lý CRM</a>
                        @endif
                        @if(empty($permissions) || !in_array('package.index',$permissions))
                            @if($roleGlobal->permission('settings'))
                                <a class="dropdown-item" href="{!! route('package.index') !!}"><i
                                        class="dropdown-icon mdi mdi-monitor"></i> Quản lý gói nạp ví</a>
                            @endif
                        @endif
                        @if(empty($permissions) || !in_array('settings.index',$permissions))
                            @if($roleGlobal->permission('settings'))
                                <a class="dropdown-item" href="{!! route('settings.index') !!}"><i
                                        class="dropdown-icon mdi mdi-settings"></i> Cài đặt chung</a>
                            @endif
                        @endif

                        @if($roleGlobal->permission('roles.list'))
                            <a class="dropdown-item" href="{!! route('roles.index') !!}"><i
                                    class="dropdown-icon mdi mdi-percent"></i> Quản lý phân quyền</a>
                        @endif

                        @if($roleGlobal->permission('leaderSale'))
                            <div class="col" style="color: #7490BD;font-weight: 400">
                                <label class="switch">
                                    <input name="checkbox" class="check"
                                           type="checkbox" {{setting('view_customer_sale')==\App\Constants\StatusCode::ON?'checked':''}}>
                                    <span class="slider round"></span>
                                </label>
                                Sale xem tất cả KH
                            </div>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="{!! url('/logout') !!}" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="dropdown-icon mdi mdi-logout-variant"></i>
                            Đăng xuất
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
    $('.check').change(function () {
        if (this.checked) {
            var value = 1;
        } else {
            var value = 0;
        }
        $.ajax({
            url: "{{url('ajax/settings')}}",
            method: "get",
            data: {
                value: value,
            }
        }).done(function (data) {

        });
    })
</script>

<!-- Horizantal menu-->
